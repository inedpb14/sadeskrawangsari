<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (! auth()->guard('admin')->check()) {
            return redirect()->route('admin.login')->with('error', 'Silahkan login sebagai admin terlebih dahulu.');
        }

        return $next($request);
    }
}
