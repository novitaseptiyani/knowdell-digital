<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'full_name'   => ['required', 'string', 'max:255'],
            'email'       => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'gender'      => ['required', 'in:Laki-laki,Perempuan'],
            'phone'       => ['required', 'string', 'max:20'],
            'birth_date'  => ['required', 'date', 'before:today'],
            'institution' => ['required', 'string', 'max:255'],
            'status'      => ['required', 'in:Pelajar,Mahasiswa,Umum'],
            'password'    => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'full_name'   => $request->full_name,
            'email'       => $request->email,
            'gender'      => $request->gender,
            'phone'       => $request->phone,
            'birth_date'  => $request->birth_date,
            'institution' => $request->institution,
            'status'      => $request->status,
            'password'    => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
