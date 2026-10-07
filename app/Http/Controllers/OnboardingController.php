<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnboardingController extends Controller
{
    public function show()
    {
        // Kalau sudah pernah isi, langsung ke dashboard
        if (Auth::user()->dream_jobs !== null) {
            return redirect()->route('dashboard');
        }

        return view('onboarding');
    }

    public function store(Request $request)
    {
        $request->validate([
            'dream_jobs'              => 'required|array|size:3',
            'dream_jobs.*'            => 'required|string|max:255',
            'work_history'            => 'nullable|array',
            'work_history.*.job'      => 'required_with:work_history|string|max:255',
            'work_history.*.duration' => 'required_with:work_history|string|max:100',
        ], [
            'dream_jobs.required'     => 'Pekerjaan impian wajib diisi.',
            'dream_jobs.*.required'   => 'Semua kolom pekerjaan impian wajib diisi.',
            'dream_jobs.*.max'        => 'Pekerjaan impian maksimal 255 karakter.',
            'work_history.*.job.required_with'      => 'Nama pekerjaan wajib diisi.',
            'work_history.*.duration.required_with' => 'Durasi pekerjaan wajib dipilih.',
        ]);

        $user = Auth::user();
        $user->dream_jobs   = $request->dream_jobs;
        $user->work_history = $request->work_history ?? [];
        $user->save();

        return redirect()->route('dashboard')->with('status', 'onboarding-complete');
    }
}
