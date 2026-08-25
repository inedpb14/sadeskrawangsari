<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Keluarga;
use App\Models\Pengaduan;
use App\Models\PengajuanSurat;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardAdminController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $periode = $request->query('periode', 'semua');

        // Filter ini SEKARANG HANYA akan dipakai untuk Surat, Keluhan, dan Berita
        $filterDate = function ($query) use ($periode) {
            if ($periode == 'bulan_ini') {
                $query->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'));
            }
        };

        // 1. STATISTIK KARTU ATAS
        $stats = [
            // PERBAIKAN: Total warga bersifat akumulatif (tidak difilter bulan)
            'total_warga' => Warga::count(),

            // Surat dan Berita tetap difilter
            'pending' => PengajuanSurat::where('status', 'Diajukan')->where($filterDate)->count(),
            'selesai' => PengajuanSurat::where('status', 'Disetujui')->where($filterDate)->count(),
            'berita' => Berita::where($filterDate)->count(),
        ];

        // 2. PERMOHONAN SURAT TERBARU (Tetap difilter waktu)
        $permohonan_terbaru = PengajuanSurat::with(['warga', 'jenisSurat'])
            ->where($filterDate)
            ->latest()
            ->take(5)
            ->get();

        // 3. ANALISA DEMOGRAFI & KELUARGA (PERBAIKAN: Semua filter waktu dihapus)
        $jmlKeluarga = Keluarga::count();
        $avgAnggota = $jmlKeluarga > 0 ? round($stats['total_warga'] / $jmlKeluarga, 1) : 0;

        $kkTerbanyak = Keluarga::withCount('anggota')->orderByDesc('anggota_count')->first();
        $kkTersedikit = Keluarga::withCount('anggota')->orderBy('anggota_count')->first();
        $wargaTertua = Warga::whereNotNull('tanggal_lahir')->orderBy('tanggal_lahir', 'asc')->first();
        $avgUmur = Warga::whereNotNull('tanggal_lahir')->selectRaw('AVG(TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE())) as rata_umur')->value('rata_umur');

        $analisaDemografi = [
            'avg_anggota' => $avgAnggota,
            'kk_terbanyak' => $kkTerbanyak,
            'kk_tersedikit' => $kkTersedikit,
            'warga_tertua' => $wargaTertua,
            'avg_umur' => round($avgUmur ?? 0, 1),
        ];

        // 4. ANALISA KELUHAN (Tetap difilter waktu)
        $keluhanMasuk = Pengaduan::where($filterDate)->count();
        $keluhanSelesai = Pengaduan::where('status', 'Selesai')->where($filterDate)->count();
        $kategoriTerbanyak = Pengaduan::where($filterDate)->select('kategori', DB::raw('count(*) as total'))->groupBy('kategori')->orderByDesc('total')->first();
        $kontributorTerbanyak = Pengaduan::where('status', 'Selesai')->where($filterDate)->select('warga_nik', DB::raw('count(*) as total'))->groupBy('warga_nik')->orderByDesc('total')->with('warga')->first();

        $analisaKeluhan = [
            'masuk' => $keluhanMasuk,
            'selesai' => $keluhanSelesai,
            'kategori_terbanyak' => $kategoriTerbanyak,
            'kontributor_terbanyak' => $kontributorTerbanyak,
        ];

        // 5. DATA UNTUK CHART (GRAFIK) - Tetap difilter waktu
        // Chart 1: Status Surat
        $chartSuratData = PengajuanSurat::where($filterDate)->select('status', DB::raw('count(*) as total'))->groupBy('status')->pluck('total', 'status')->toArray();
        $chartSurat = [
            'Diajukan' => $chartSuratData['Diajukan'] ?? 0,
            'Diproses' => $chartSuratData['Diproses'] ?? 0,
            'Disetujui' => $chartSuratData['Disetujui'] ?? 0,
            'Ditolak' => $chartSuratData['Ditolak'] ?? 0,
        ];

        // Chart 2: Kategori Keluhan
        $chartKeluhanData = Pengaduan::where($filterDate)->select('kategori', DB::raw('count(*) as total'))->groupBy('kategori')->pluck('total', 'kategori')->toArray();
        $chartKeluhan = [
            'labels' => empty($chartKeluhanData) ? ['Belum ada data'] : array_keys($chartKeluhanData),
            'data' => empty($chartKeluhanData) ? [0] : array_values($chartKeluhanData),
        ];

        return view('admin.dashboard', compact('user', 'stats', 'permohonan_terbaru', 'periode', 'analisaDemografi', 'analisaKeluhan', 'chartSurat', 'chartKeluhan'));
    }

    public function suratMasuk(Request $request)
    {
        $user = Auth::user();
        $query = PengajuanSurat::with(['warga', 'jenisSurat'])->latest();

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $surat = $query->paginate(10);

        return view('admin.surat-masuk', compact('user', 'surat'));
    }

    public function prosesSurat($id, $status)
    {
        $pengajuan = PengajuanSurat::findOrFail($id);
        $pengajuan->update(['status' => $status]);

        return back()->with('success', 'Status permohonan berhasil diperbarui menjadi '.$status);
    }
}
