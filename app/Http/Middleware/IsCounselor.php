<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsCounselor
{
    public function handle(Request $request, Closure $next): Response
    {
        if (
            Auth::guard('staff')->check() &&
            Auth::guard('staff')->user()->role === 'counselor'
        ) {
            return $next($request);
        }

        return redirect('/')->with(
            'error',
            'Hanya konselor yang dapat mengakses halaman ini.'
        );
    }
}