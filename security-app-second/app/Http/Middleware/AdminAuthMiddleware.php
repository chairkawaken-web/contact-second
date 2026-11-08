<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::guard('admin')->check() && ! session('admin_logged_in')) {
            return redirect('/admin/login');
        }

        if (session('admin_logged_in') && ! Auth::guard('admin')->check()) {
            $admin = app(\App\Auth\ConfigAdminUserProvider::class)->retrieveByCredentials([
                'email' => config('admin.email'),
            ]);

            if ($admin) {
                Auth::guard('admin')->login($admin);
            }
        }

        return $next($request);
    }
}
