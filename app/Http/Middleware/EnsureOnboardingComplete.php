<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureOnboardingComplete
{
    public function handle(Request $request, Closure $next): Response
    {
        // Kalau user belum isi dream_jobs → redirect ke halaman onboarding
        if (Auth::guard('web')->check() && Auth::guard('web')->user()->dream_jobs === null) {
            return redirect()->route('onboarding');
        }

        return $next($request);
    }
}
