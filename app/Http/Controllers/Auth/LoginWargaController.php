<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginWargaController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login-warga');
    }

    public function login(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nik' => 'required|string',
            'password' => 'required',
        ]);

        // 2. Cari data warga berdasarkan NIK
        $warga = Warga::where('nik', $request->nik)->first();

        if (! $warga) {
            return back()->withErrors(['nik' => 'NIK tidak terdaftar dalam data warga.'])->withInput();
        }

        // 3. Cari akun di tabel users menggunakan user_id yang ada di tabel warga
        $user = User::find($warga->user_id);

        if (! $user) {
            return back()->withErrors(['nik' => 'Akun login tidak ditemukan untuk NIK ini.'])->withInput();
        }

        // 4. Cek kecocokan password dengan yang ada di tabel users
        if (Hash::check($request->password, $user->password)) {

            // 5. Login-kan spesifik ke guard 'warga' menggunakan objek $warga
            // Gunakan metode login(), BUKAN attempt() agar tidak mencari password di tabel warga
            $remember = $request->has('remember');
            Auth::guard('warga')->login($warga, $remember);

            // 6. Regenerate session untuk keamanan (mencegah session fixation)
            $request->session()->regenerate();

            return redirect()->route('dashboard.warga');
        }

        // 7. Jika password salah
        return back()->withErrors(['nik' => 'Password yang Anda masukkan salah.'])->withInput();
    }

    public function logout(Request $request)
    {
        // Pastikan logout dilakukan spesifik pada guard 'warga'
        Auth::guard('warga')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
