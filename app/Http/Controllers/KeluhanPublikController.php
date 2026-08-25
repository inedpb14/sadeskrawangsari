<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Support\Facades\DB;

class KeluhanPublikController extends Controller
{
    public function index()
    {
        $pengaturan = DB::table('pengaturan_desa')->where('id', 1)->first();

        // Ambil semua keluhan dari yang terbaru
        $keluhan = Pengaduan::with('warga')->latest()->paginate(12);

        // Hitung statistik untuk publik
        $stats = [
            'total' => Pengaduan::count(),
            'selesai' => Pengaduan::where('status', 'Selesai')->count(),
            'diproses' => Pengaduan::whereIn('status', ['Menunggu', 'Diproses'])->count(),
        ];

        return view('keluhan', compact('keluhan', 'pengaturan', 'stats'));
    }
}
