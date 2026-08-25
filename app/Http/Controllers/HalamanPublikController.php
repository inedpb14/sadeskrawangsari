<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use Illuminate\Support\Facades\DB;

class HalamanPublikController extends Controller
{
    // Mengambil data pengaturan_desa (Nama kades, sejarah, dll)
    private function getPengaturan()
    {
        return DB::table('pengaturan_desa')->where('id', 1)->first();
    }

    // --- PROFIL DESA ---
    public function sejarah()
    {
        $pengaturan = $this->getPengaturan();

        return view('publik.profil-sejarah', compact('pengaturan'));
    }

    public function visiMisi()
    {
        $pengaturan = $this->getPengaturan();

        return view('publik.profil-visimisi', compact('pengaturan'));
    }

    public function perangkat()
    {
        $pengaturan = $this->getPengaturan();

        // Anda bisa mengambil data admin/perangkat desa di sini nantinya
        return view('publik.profil.perangkat', compact('pengaturan'));
    }

    // --- LAYANAN PENDUDUK ---
    public function panduan()
    {
        $pengaturan = $this->getPengaturan();

        return view('publik.layanan-panduan', compact('pengaturan'));
    }

    public function ajukan()
    {
        $pengaturan = $this->getPengaturan();

        return view('publik.layanan.ajukan', compact('pengaturan'));
    }

    public function status()
    {
        $pengaturan = $this->getPengaturan();

        return view('publik.layanan.status', compact('pengaturan'));
    }

    // --- STATISTIK PENDUDUK ---
    public function statistik()
    {
        $pengaturan = $this->getPengaturan();

        // Mengambil data statistik demografi nyata dari database Warga
        $stats = [
            'total' => Warga::count(),
            'laki_laki' => Warga::where('jenis_kelamin', 'L')->count(),
            'perempuan' => Warga::where('jenis_kelamin', 'P')->count(),

            // Rentang Umur (Menggunakan query Raw)
            'anak' => Warga::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) < 17')->count(),
            'dewasa' => Warga::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 17 AND 59')->count(),
            'lansia' => Warga::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) >= 60')->count(),
        ];

        return view('publik.statistik', compact('pengaturan', 'stats'));
    }
}
