<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EnsureAdminIsVerified
{
    public function handle($request, Closure $next)
    {
        if (Auth::guard('admin')->check() && !Auth::guard('admin')->user()->hasVerifiedEmail()) {
            return redirect('/admin/email/verify');
        }

        return $next($request);
    }
}
