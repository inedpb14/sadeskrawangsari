<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Jika dia mencoba mengakses rute warga dan sudah login sebagai warga, izinkan
        if (in_array('warga', $roles) && Auth::guard('warga')->check()) {
            return $next($request);
        }

        // Jika dia mencoba mengakses rute admin/kades
        if (Auth::guard('web')->check() && in_array(Auth::user()->role, $roles)) {
            return $next($request);
        }

        abort(403, 'Anda tidak memiliki akses ke halaman ini');
    }
}
