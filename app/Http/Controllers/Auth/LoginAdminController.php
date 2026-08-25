<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginAdminController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login-admin');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $cekUser = User::where('email', $request->email)->first();

        if (! $cekUser) {
            return back()->withErrors(['email' => 'Email tidak terdaftar.'])->withInput();
        }

        if (! Hash::check($request->password, $cekUser->password)) {
            return back()->withErrors(['email' => 'Password salah.'])->withInput();
        }

        // 1. Panggil guard 'web' secara EKSPLISIT
        if (Auth::guard('web')->attempt($credentials, $request->has('remember'))) {

            // 2. Ambil data user dari guard 'web'
            $user = Auth::guard('web')->user();

            if ($user->role === 'admin' || $user->role === 'kades') {
                $request->session()->regenerate();

                return redirect()->intended('/dashboard-admin');
            }

            // 3. Logout dari guard 'web' jika rolenya salah
            Auth::guard('web')->logout();

            return back()->withErrors(['email' => 'Anda tidak memiliki akses admin.']);
        }

        return back()->withErrors(['email' => 'Email atau Password salah.'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login-admin');
    }
}
