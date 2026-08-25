<?php

namespace App\Http\Controllers\Penduduk;

use App\Http\Controllers\Controller;
use App\Models\PengajuanSurat;
use App\Models\Warga;
use Illuminate\Support\Facades\Auth;

class RiwayatPengajuanController extends Controller
{
    public function index()
    {
        // Ambil data warga yang sedang login
        $user = Auth::guard('warga')->user();

        // Kumpulkan semua NIK dalam 1 KK (termasuk NIK user yang login)
        if ($user->no_kk) {
            // Jika sudah punya KK, ambil daftar semua NIK anggota keluarga
            $list_nik = Warga::where('no_kk', $user->no_kk)->pluck('nik')->toArray();
        } else {
            // Jika belum punya KK, tampilkan berdasarkan NIK sendiri saja
            $list_nik = [$user->nik];
        }

        // Ambil data pengajuan menggunakan whereIn (mencari banyak NIK sekaligus)
        // Tambahkan relasi 'warga' agar kita bisa memanggil nama pemohon di tampilan
        $riwayat = PengajuanSurat::with(['jenisSurat', 'warga'])
            ->whereIn('warga_nik', $list_nik)
            ->orderBy('created_at', 'desc')
            ->paginate(10)->withQueryString();

        return view('warga.riwayat', compact('riwayat'));
    }
}
