<?php

namespace App\Http\Controllers;

use App\Models\TestResult;
use App\Models\TestSession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CounselorController extends Controller
{
    public function dashboard()
    {
        $counselor  = Auth::guard('staff')->user();
        $patientIds = $counselor->patients()->pluck('users.id');

        $totalPatients   = $patientIds->count();
        $totalFinished   = TestSession::whereIn('user_id', $patientIds)->where('status', 'finished')->count();
        $totalUnreviewed = TestResult::whereHas('testSession', function ($q) use ($patientIds) {
            $q->whereIn('user_id', $patientIds)->where('status', 'finished');
        })->where('is_reviewed', false)->count();

        $stats = [
            'total_patients'   => $totalPatients,
            'total_finished'   => $totalFinished,
            'total_unreviewed' => $totalUnreviewed,
        ];

        $latestResults = TestSession::with(['user', 'category', 'testResult'])
            ->whereIn('user_id', $patientIds)
            ->where('status', 'finished')
            ->latest('finished_at')
            ->paginate(10);

        return view('counselor.dashboard', compact('stats', 'latestResults'));
    }

    public function patients(Request $request)
    {
        $counselor  = Auth::guard('staff')->user();
        $patientIds = $counselor->patients()->pluck('users.id');

        $query = \App\Models\User::whereIn('id', $patientIds)->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('institution', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tanggal')) {
            $query->whereHas('testSessions', function ($q) use ($request) {
                $q->whereDate('finished_at', $request->tanggal)->where('status', 'finished');
            });
        }

        $patients = $query->paginate(10);
        return view('counselor.patients', compact('patients'));
    }

    public function showPatient(Request $request, $userId)
    {
        $counselor = Auth::guard('staff')->user();

        $patient = User::whereHas('counselor', function ($q) use ($counselor) {
            $q->where('counselor_id', $counselor->id);
        })->findOrFail($userId);

        $query = TestSession::with(['category', 'testResult'])
            ->where('user_id', $patient->id)
            ->where('status', 'finished');

        if ($request->filled('tes')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->tes);
            });
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('finished_at', $request->tanggal);
        }

        $sessions = $query->latest('finished_at')->paginate(10);
        return view('counselor.detail_patient', compact('patient', 'sessions'));
    }

    public function showResult($sessionId)
    {
        $counselor = Auth::guard('staff')->user();

        $session = TestSession::with(['category', 'testResult', 'cardSessions.card', 'cardSessions.choiceCategory'])
            ->whereHas('user.counselor', function ($q) use ($counselor) {
                $q->where('counselor_id', $counselor->id);
            })
            ->findOrFail($sessionId);

        return view('counselor.result', compact('session'));
    }

    public function saveRecommendation(Request $request, $sessionId)
    {
        $counselor = Auth::guard('staff')->user();

        $request->validate(['recommendation' => 'required|string|max:5000']);

        $session = TestSession::whereHas('user.counselor', function ($q) use ($counselor) {
            $q->where('counselor_id', $counselor->id);
        })->findOrFail($sessionId);

        $session->testResult()->updateOrCreate(
            ['session_id' => $session->id],
            ['recommendation' => $request->recommendation, 'is_reviewed' => true]
        );

        return back()->with('status', 'recommendation-saved');
    }

    public function exportResults(Request $request)
    {
        $counselor = Auth::guard('staff')->user();
        $fileName  = 'Hasil_Tes_Knowdell_' . date('Y-m-d_His') . '.csv';
        $columns   = ['ID Klien', 'Nama Klien', 'Email', 'Institusi', 'Jenis Tes', 'Tanggal Selesai', 'Durasi (menit)', 'Sudah Direview'];

        $query = TestSession::with(['user', 'category', 'testResult'])
            ->whereIn('user_id', User::whereHas('counselor', function ($q) use ($counselor) {
                $q->where('counselor_id', $counselor->id);
            })->pluck('id'))
            ->where('status', 'finished');

        if ($request->filled('tes')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->tes);
            });
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('finished_at', $request->tanggal);
        }

        $sessions = $query->latest('finished_at')->get();

        $callback = function () use ($columns, $sessions) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($sessions as $session) {
                fputcsv($file, [
                    $session->user->id,
                    $session->user->full_name,
                    $session->user->email,
                    $session->user->institution,
                    $session->category->name,
                    $session->finished_at,
                    round($session->duration / 60),
                    $session->testResult?->is_reviewed ? 'Ya' : 'Tidak',
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, [
            'Content-type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename={$fileName}",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ]);
    }

    public function profile()
    {
        return view('staff.profile');
    }

    public function updateProfile(Request $request)
    {
        $staff = Auth::guard('staff')->user();

        $request->validate([
            'full_name'      => 'required|string|max:255',
            'email'          => 'required|email|max:255|unique:staff,email,' . $staff->id,
            'phone'          => 'nullable|string|max:20',
            'birth_date'     => 'nullable|date|before:today',
            'gender'         => 'nullable|string|max:20',
            'institution'    => 'nullable|string|max:255',
            'title'          => 'nullable|string|max:100',
            'specialization' => 'nullable|string|max:255',
            'biography'      => 'nullable|string|max:5000',
        ]);

        $staff->full_name      = $request->full_name;
        $staff->email          = $request->email;
        $staff->phone          = $request->phone;
        $staff->birth_date     = $request->birth_date;
        $staff->gender         = $request->gender;
        $staff->institution    = $request->institution;
        $staff->title          = $request->title;
        $staff->specialization = $request->specialization;
        $staff->biography      = $request->biography;
        $staff->save();

        $status = ($request->filled('biography') || $request->filled('title') || $request->filled('specialization'))
            ? 'bio-updated'
            : 'profile-updated';

        return back()->with('status', $status);
    }

    public function updatePassword(Request $request)
    {
        // 1. Validasi format dasar input
        $request->validateWithBag('updatePassword', [
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ], [
            // Custom pesan error bahasa Indonesia
            'current_password.required' => 'Kata sandi lama wajib diisi.',
            'password.required'         => 'Kata sandi baru wajib diisi.',
            'password.min'              => 'Kata sandi baru minimal harus 8 karakter.',
            'password.confirmed'        => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        $staff = Auth::guard('staff')->user();

        // 2. Validasi apakah kata sandi lama sudah benar
        if (!Hash::check($request->current_password, $staff->password)) {
            return back()->withErrors([
                'current_password' => 'Kata sandi lama tidak sesuai.'
            ], 'updatePassword');
        }

        // 3. VALIDASI TAMBAHAN: Apakah kata sandi baru sama dengan kata sandi lama?
        if (Hash::check($request->password, $staff->password)) {
            return back()->withErrors([
                'password' => 'Kata sandi baru tidak boleh sama dengan kata sandi lama.'
            ], 'updatePassword');
        }

        // 4. Jika lolos semua pengecekan, simpan kata sandi baru
        $staff->password = Hash::make($request->password);
        $staff->save();

        return back()->with('status', 'password-updated');
    }

    public function completedTests(Request $request)
    {
        $counselor  = Auth::guard('staff')->user();
        $patientIds = $counselor->patients()->pluck('users.id');

        $query = TestSession::with(['user', 'category', 'testResult'])
            ->whereIn('user_id', $patientIds)
            ->where('status', 'finished');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('institution', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tes')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->tes);
            });
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('finished_at', $request->tanggal);
        }

        $completedTests = $query->latest('finished_at')->paginate(10);
        return view('counselor.completed_tests', compact('completedTests'));
    }

    public function unreviewedTests(Request $request)
    {
        $counselor  = Auth::guard('staff')->user();
        $patientIds = $counselor->patients()->pluck('users.id');

        $query = TestSession::with(['user', 'category', 'testResult'])
            ->whereIn('user_id', $patientIds)
            ->where('status', 'finished')
            ->where(function ($q) {
                $q->whereDoesntHave('testResult')
                    ->orWhereHas('testResult', function ($q2) {
                        $q2->where('is_reviewed', false);
                    });
            });

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('institution', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tes')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->tes);
            });
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('finished_at', $request->tanggal);
        }

        $completedTests = $query->latest('finished_at')->paginate(10);
        return view('counselor.unreviewed', compact('completedTests'));
    }

    public function exportPatients()
    {
        $counselor = Auth::guard('staff')->user();
        $fileName  = 'Daftar_Klien_' . date('Y-m-d_His') . '.csv';
        $columns   = ['ID', 'Nama Lengkap', 'Email', 'No. Ponsel', 'Jenis Kelamin', 'Status', 'Instansi', 'Tanggal Daftar'];

        $patients = \App\Models\User::whereHas('counselor', function ($q) use ($counselor) {
            $q->where('counselor_id', $counselor->id);
        })->latest()->get();

        $callback = function () use ($columns, $patients) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($patients as $patient) {
                fputcsv($file, [
                    $patient->id,
                    $patient->full_name,
                    $patient->email,
                    $patient->phone      ?? '-',
                    $patient->gender     ?? '-',
                    $patient->status     ?? '-',
                    $patient->institution ?? '-',
                    $patient->created_at->format('d M Y'),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, [
            'Content-type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename={$fileName}",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ]);
    }

    public function updateBiography(Request $request)
    {
        $staff = Auth::guard('staff')->user();

        $request->validate([
            'title'          => 'nullable|string|max:100',
            'specialization' => 'nullable|string|max:255',
            'biography'      => 'required|string|min:10|max:5000',
        ], [
            'biography.required' => 'Kolom biografi tidak boleh kosong.',
            'biography.min'      => 'Biografi minimal 10 karakter.',
            'biography.max'      => 'Biografi maksimal 5.000 karakter.',
            'title.max'          => 'Gelar akademik maksimal 100 karakter.',
            'specialization.max' => 'Bidang spesialisasi maksimal 255 karakter.',
        ]);

        $staff->title          = $request->title;
        $staff->specialization = $request->specialization;
        $staff->biography      = $request->biography;
        $staff->save();

        return back()->with('status', 'bio-updated');
    }

    public function publicProfile($id)
    {
        $counselor = \App\Models\Staff::where('role', 'counselor')->findOrFail($id);
        return view('counselor.public_profile', compact('counselor'));
    }
}
