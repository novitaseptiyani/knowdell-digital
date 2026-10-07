<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit');
    }

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::guard('web')->user();

        $request->validate([
            'full_name'   => 'required|string|max:255',
            'email'       => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone'       => 'nullable|string|max:20',
            'birth_date'  => 'nullable|date|before:today',
            'gender'      => 'nullable|string|max:20',
            'status'      => 'nullable|string|max:20',
            'institution' => 'nullable|string|max:255',
        ]);

        $user->full_name   = $request->full_name;
        $user->email       = $request->email;
        $user->phone       = $request->phone;
        $user->birth_date  = $request->birth_date;
        $user->gender      = $request->gender;
        $user->status      = $request->status;
        $user->institution = $request->institution;
        $user->save();

        return redirect('/profile')->with('status', 'profile-updated');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validateWithBag('updatePassword', [
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ], [
            'current_password.required' => 'Kata sandi lama wajib diisi.',
            'password.required'         => 'Kata sandi baru wajib diisi.',
            'password.min'              => 'Kata sandi baru minimal harus 8 karakter.',
            'password.confirmed'        => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        $user = Auth::guard('web')->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Kata sandi lama tidak sesuai.'
            ], 'updatePassword');
        }

        if (Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Kata sandi baru tidak boleh sama dengan kata sandi lama.'
            ], 'updatePassword');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect('/profile')->with('status', 'password-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function updateCareer(Request $request): RedirectResponse
    {
        $request->validate([
            'dream_jobs'              => 'required|array|size:3',
            'dream_jobs.*'            => 'required|string|max:255',
            'work_history'            => 'nullable|array',
            'work_history.*.job'      => 'required_with:work_history|string|max:255',
            'work_history.*.duration' => 'required_with:work_history|string|max:100',
        ], [
            'dream_jobs.*.required' => 'Semua pekerjaan impian wajib diisi.',
            'dream_jobs.*.max'      => 'Pekerjaan impian maksimal 255 karakter.',
        ]);

        $user = Auth::guard('web')->user();
        $user->dream_jobs   = $request->dream_jobs;
        $user->work_history = $request->work_history ?? [];
        $user->save();

        return back()->with('status', 'career-updated');
    }
}
