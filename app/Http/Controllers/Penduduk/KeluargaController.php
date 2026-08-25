<?php

namespace App\Http\Controllers\Penduduk;

use App\Http\Controllers\Controller;
use App\Models\Keluarga;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeluargaController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Cari data keluarga berdasarkan no_kk user yang login
        $keluarga = Keluarga::with('anggota')->find($user->no_kk);

        return view('warga.keluarga', compact('user', 'keluarga'));
    }

    public function storeKeluarga(Request $request)
    {
        $request->validate([
            'no_kk' => 'required|digits:16|unique:keluarga,no_kk',
            'nama_kepala_keluarga' => 'required|string|max:150',
        ]);

        Keluarga::create($request->all());

        // Otomatis update no_kk di profil user yang sedang login
        Warga::where('nik', Auth::user()->nik)->update(['no_kk' => $request->no_kk]);

        return back()->with('success', 'Data Keluarga berhasil dibuat!');
    }

    public function addAnggota(Request $request)
    {
        $request->validate([
            'nik' => 'required|digits:16',
            'nama_lengkap' => 'required|string|max:150',
        ]);

        $user = Auth::user();

        // Cek NIK apakah sudah terdaftar
        $existingWarga = Warga::where('nik', $request->nik)->first();

        if ($existingWarga) {
            // NIK sudah ada - cek apakah sudah punya user_id (sudah punya akun login)
            if ($existingWarga->user_id) {
                return back()->with('error', 'NIK ini sudah terdaftar dan memiliki akun login.')->withInput();
            }
            // NIK ada tapi belum punya user_id -> bisa ditambahkan ke KK user ini
            $existingWarga->update([
                'no_kk' => $user->no_kk,
                'nama_lengkap' => $request->nama_lengkap,
            ]);
        } else {
            // NIK belum ada -> create baru
            Warga::create([
                'nik' => $request->nik,
                'nama_lengkap' => $request->nama_lengkap,
                'no_kk' => $user->no_kk,
                'is_active' => 1,
            ]);
        }

        return back()->with('success', 'Anggota keluarga berhasil ditambahkan!');
    }
}
