<?php

namespace App\Http\Controllers\Penduduk;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\PengajuanSurat;
use Illuminate\Support\Facades\Auth;

class DashboardWargaController extends Controller
{
    public function index()
    {
        $user = Auth::guard('warga')->user();

        $stats = [
            'total' => PengajuanSurat::where('warga_nik', $user->nik)->count(),
            'proses' => PengajuanSurat::where('warga_nik', $user->nik)->where('status', 'Diproses')->count(),
            'selesai' => PengajuanSurat::where('warga_nik', $user->nik)->where('status', 'Disetujui')->count(),
        ];

        $berita = Berita::where('status', 'publish')->latest()->take(3)->get();

        return view('warga.dashboard', compact('user', 'stats', 'berita'));
    }
}
