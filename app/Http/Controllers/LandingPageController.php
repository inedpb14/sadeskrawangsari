<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\DB; // Pastikan Model Pengaduan di-import

class LandingPageController extends Controller
{
    public function index()
    {
        $pengaturan = DB::table('pengaturan_desa')->where('id', 1)->first();

        // Ambil 3 berita terbaru
        $berita = Berita::where('status', 'publish')->latest()->take(3)->get();

        // Ambil 3 keluhan warga yang sudah berstatus 'Selesai'
        $keluhan_selesai = Pengaduan::with('warga')
            ->where('status', 'Selesai')
            ->latest('updated_at')
            ->take(3)
            ->get();

        return view('landingpage', compact('pengaturan', 'berita', 'keluhan_selesai'));
    }
}
