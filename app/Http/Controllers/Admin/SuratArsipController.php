<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuratArsipController extends Controller
{
    public function index(Request $request)
    {
        // ==========================================
        // 1. Inisialisasi Filter Waktu (Default Bulan Ini)
        // ==========================================
        $bulanTerpilih = $request->input('bulan', date('m')); // Default bulan berjalan (01-12)
        $tahunTerpilih = $request->input('tahun', date('Y')); // Default tahun berjalan

        // Menyiapkan daftar tahun untuk dropdown (contoh: dari 2024 sampai tahun saat ini)
        $tahunTersedia = range(2024, date('Y'));

        // Base Query untuk Tabel
        $query = PengajuanSurat::with(['warga', 'jenisSurat'])
            ->whereIn('status', ['Disetujui', 'Ditolak']);

        // Base Query untuk Chart
        $chartQuery = DB::table('pengajuan_surat')
            ->join('jenis_surat', 'pengajuan_surat.jenis_surat_id', '=', 'jenis_surat.id')
            ->whereIn('pengajuan_surat.status', ['Disetujui', 'Ditolak']);

        // ==========================================
        // 2. Terapkan Filter Waktu ke Tabel & Chart
        // ==========================================
        if ($bulanTerpilih != 'semua') {
            $query->whereMonth('updated_at', $bulanTerpilih);
            $chartQuery->whereMonth('pengajuan_surat.updated_at', $bulanTerpilih);
        }

        if ($tahunTerpilih != 'semua') {
            $query->whereYear('updated_at', $tahunTerpilih);
            $chartQuery->whereYear('pengajuan_surat.updated_at', $tahunTerpilih);
        }

        // ==========================================
        // 3. Filter Ekstra untuk Tabel (Status, Kategori, Search)
        // ==========================================
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('jenis_surat')) {
            $query->where('jenis_surat_id', $request->jenis_surat);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_surat', 'like', '%'.$search.'%')
                    ->orWhereHas('warga', function ($wargaQuery) use ($search) {
                        $wargaQuery->where('nama_lengkap', 'like', '%'.$search.'%')
                            ->orWhere('nik', 'like', '%'.$search.'%');
                    });
            });
        }

        // Sorting
        $sort = $request->input('sort', 'terbaru');
        if ($sort == 'terlama') {
            $query->orderBy('updated_at', 'asc');
        } elseif ($sort == 'nama_az') {
            $query->join('warga', 'pengajuan_surat.warga_nik', '=', 'warga.nik')
                ->orderBy('warga.nama_lengkap', 'asc')
                ->select('pengajuan_surat.*');
        } elseif ($sort == 'nama_za') {
            $query->join('warga', 'pengajuan_surat.warga_nik', '=', 'warga.nik')
                ->orderBy('warga.nama_lengkap', 'desc')
                ->select('pengajuan_surat.*');
        } else {
            $query->orderBy('updated_at', 'desc');
        }

        // Paginasi
        $perPage = $request->input('per_page', 10);
        $arsip = $query->paginate($perPage)->withQueryString();

        // ==========================================
        // 4. Eksekusi Query Chart Data
        // ==========================================
        $chartDataRaw = $chartQuery
            ->select('jenis_surat.nama_surat', DB::raw('count(*) as total'))
            ->groupBy('jenis_surat.id', 'jenis_surat.nama_surat')
            ->orderBy('total', 'desc')
            ->get();

        $chartLabels = $chartDataRaw->pluck('nama_surat')->toArray();
        $chartCounts = $chartDataRaw->pluck('total')->toArray();

        // Data dropdown jenis surat
        $jenis_surat_list = DB::table('jenis_surat')->get();

        return view('admin.surat-arsip', compact(
            'arsip',
            'jenis_surat_list',
            'chartLabels',
            'chartCounts',
            'bulanTerpilih',
            'tahunTerpilih',
            'tahunTersedia'
        ));
    }
}
