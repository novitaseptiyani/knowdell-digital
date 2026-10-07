<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Redirect ke dashboard sesuai role
                if (Auth::guard('staff')->check()) {
                    $staff = Auth::guard('staff')->user();
                    if ($staff->role === 'admin') {
                        return redirect()->route('admin.dashboard');
                    }
                    return redirect()->route('counselor.dashboard');
                }
                return redirect()->route('dashboard');
            }
        }

        return $next($request);
    }
}