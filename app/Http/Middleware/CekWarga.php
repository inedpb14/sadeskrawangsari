<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CekWarga
{
    public function handle(Request $request, Closure $next): Response
    {
        // Jika user TIDAK login melalui guard warga, tendang ke halaman login
        if (! Auth::guard('warga')->check()) {
            return redirect()->route('login.warga')->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}
