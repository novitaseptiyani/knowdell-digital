<?php

namespace App\Http\Controllers;

use App\Models\CounselorUser;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users'      => User::count(),
            'total_counselors' => Staff::where('role', 'counselor')->count(),
            'total_tests'      => \App\Models\TestSession::where('status', 'finished')->count(),
        ];

        $recentUsers = User::latest()->paginate(10);

        // Statistik penggunaan per instrumen (category_id 1-4)
        $instrumentLabels = [
            1 => 'Career Values',
            2 => 'Motivated Skills',
            3 => 'Leisure & Retirement',
            4 => 'Occupational Interests',
        ];

        $rawStats = \App\Models\TestSession::selectRaw('category_id, count(*) as total')
            ->where('status', 'finished')
            ->groupBy('category_id')
            ->pluck('total', 'category_id');

        // Pastikan semua 4 instrumen selalu muncul meski belum ada datanya
        $instrumentStats = [];
        foreach ($instrumentLabels as $id => $label) {
            $instrumentStats[] = [
                'label' => $label,
                'total' => $rawStats[$id] ?? 0,
            ];
        }

        return view('admin.dashboard', compact('stats', 'recentUsers', 'instrumentStats'));
    }

    public function users(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('full_name', 'like', "%{$searchTerm}%")
                    ->orWhere('email', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->latest()->paginate(10);
        return view('admin.users', compact('users'));
    }

    public function counselors(Request $request)
    {
        $query = Staff::where('role', 'counselor')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $counselors = $query->paginate(10);
        return view('admin.counselors', compact('counselors'));
    }

    public function storeCounselor(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:staff,email',
            'phone'     => 'nullable|string|max:20',
            'password'  => 'required|string|min:8|confirmed',
        ]);

        Staff::create([
            'full_name'  => $request->full_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'password'   => $request->password,
            'role'       => 'counselor',
            'created_by' => auth('staff')->id(),
        ]);

        return back()->with('status', 'counselor-created');
    }

    public function destroyCounselor(Staff $user)
    {
        if ($user->role === 'counselor') {
            $user->delete();
            return back()->with('status', 'counselor-deleted');
        }

        return back();
    }

    public function assignments(Request $request)
    {
        $query = User::latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filter === 'assigned') {
            $query->whereHas('counselor');
        } elseif ($request->filter === 'unassigned') {
            $query->whereDoesntHave('counselor');
        }

        $students   = $query->paginate(10);
        $counselors = Staff::where('role', 'counselor')->get();

        return view('admin.assignments', compact('students', 'counselors'));
    }

    public function assignCounselor(Request $request, User $user)
    {
        $request->validate([
            'counselor_id' => 'required|exists:staff,id',
        ]);

        $counselor = Staff::where('id', $request->counselor_id)
            ->where('role', 'counselor')
            ->firstOrFail();

        CounselorUser::updateOrCreate(
            ['user_id' => $user->id],
            [
                'counselor_id' => $counselor->id,
                'assigned_at'  => now(),
            ]
        );

        return back()->with('status', 'assignment-updated');
    }

    public function unassignCounselor(User $user)
    {
        CounselorUser::where('user_id', $user->id)->delete();
        return back()->with('status', 'assignment-removed');
    }

    public function exportUsers()
    {
        $fileName = 'Users_Knowdell_' . date('Y-m-d_His') . '.csv';
        $columns  = ['ID', 'Nama Lengkap', 'Email', 'Status', 'Institusi', 'Tanggal Daftar'];

        $callback = function () use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach (User::all() as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->full_name,
                    $user->email,
                    $user->status,
                    $user->institution,
                    $user->created_at,
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
            'full_name'   => 'required|string|max:255',
            'email'       => 'required|email|max:255|unique:staff,email,' . $staff->id,
            'phone'       => 'nullable|string|max:20',
            'birth_date'  => 'nullable|date|before:today',
            'gender'      => 'nullable|string|max:20',
            'institution' => 'nullable|string|max:255',
        ]);

        $staff->full_name   = $request->full_name;
        $staff->email       = $request->email;
        $staff->phone       = $request->phone;
        $staff->birth_date  = $request->birth_date;
        $staff->gender      = $request->gender;
        $staff->institution = $request->institution;
        $staff->save();

        return back()->with('status', 'profile-updated');
    }

    public function updatePassword(Request $request)
    {
        // 1. Validasi format dasar input
        $request->validateWithBag('updatePassword', [
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ], [
            // Custom pesan error bahasa Indonesia agar seragam
            'current_password.required' => 'Kata sandi lama wajib diisi.',
            'password.required'         => 'Kata sandi baru wajib diisi.',
            'password.min'              => 'Kata sandi baru minimal harus 8 karakter.',
            'password.confirmed'        => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        $staff = Auth::guard('staff')->user();

        // 2. Cek apakah kata sandi lama sudah benar
        if (!Hash::check($request->current_password, $staff->password)) {
            return back()->withErrors([
                'current_password' => 'Kata sandi lama tidak sesuai.'
            ], 'updatePassword');
        }

        // 3. INI YANG KURANG: Validasi apakah kata sandi baru sama dengan kata sandi lama
        if (Hash::check($request->password, $staff->password)) {
            return back()->withErrors([
                'password' => 'Kata sandi baru tidak boleh sama dengan kata sandi lama.'
            ], 'updatePassword');
        }

        // 4. Jika lolos semua pengecekan, simpan kata sandi baru milik Admin
        $staff->password = Hash::make($request->password);
        $staff->save();

        return back()->with('status', 'password-updated');
    }

    public function admins()
    {
        $admins = Staff::where('role', 'admin')
            ->latest()
            ->paginate(10);

        return view('admin.admins', compact('admins'));
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:staff,email',
            'phone'     => 'nullable|string|max:20',
            'password'  => 'required|string|min:8|confirmed',
        ]);

        Staff::create([
            'full_name'  => $request->full_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'password'   => $request->password,
            'role'       => 'admin',
            'created_by' => auth('staff')->id(),
        ]);

        return back()->with('status', 'admin-created');
    }

    public function destroyAdmin(Staff $user)
    {
        if ($user->id === auth('staff')->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        if ($user->role === 'admin') {
            $user->delete();
            return back()->with('status', 'admin-deleted');
        }

        return back();
    }

    public function destroyUser(User $user)
    {
        $user->delete();
        return back()->with('status', 'user-deleted');
    }
}
