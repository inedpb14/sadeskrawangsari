<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanSurat;
use App\Services\PdfSuratService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuratMasukController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = PengajuanSurat::with(['warga', 'jenisSurat'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $surat = $query->paginate(10);

        return view('admin.surat-masuk', compact('user', 'surat'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Diajukan,Diproses,Disetujui,Ditolak',
        ]);

        $pengajuan = PengajuanSurat::findOrFail($id);
        $pengajuan->update(['status' => $request->status]);

        return back()->with('success', "Status permohonan berhasil diubah menjadi {$request->status}.");
    }

    public function setujuiSurat(Request $request, $id)
    {
        // 1. Validasi: Admin HANYA menginput nomor urut bagian depannya saja (XXX)
        $request->validate([
            'no_urut' => 'required|string|max:50',
        ]);

        $pengajuan = PengajuanSurat::with('jenisSurat')->findOrFail($id);

        // Ambil kode_surat dari relasi jenisSurat (sudah eager-loaded)
        $kodeSurat = $pengajuan->jenisSurat?->kode_surat ?? 'SURAT';

        // Generate Bulan Romawi Saat Ini
        $romawi = ['', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        $bulanSekarang = date('n');
        $bulanRomawi = $romawi[$bulanSekarang];

        $tahunSekarang = date('Y');

        // Format: 145/SKTM/III/2026
        $nomorSuratLengkap = $request->no_urut.'/'.$kodeSurat.'/'.$bulanRomawi.'/'.$tahunSekarang;

        $pengajuan->update([
            'status' => 'Disetujui',
            'nomor_surat' => $nomorSuratLengkap,
        ]);

        return back()->with('success', "Surat disetujui dengan Nomor Registrasi: $nomorSuratLengkap");
    }

    // Fungsi khusus untuk menolak dan menyimpan Alasan (Keterangan Admin)
    public function tolakSurat(Request $request, $id)
    {
        $request->validate([
            'keterangan_admin' => 'required|string',
        ]);

        $pengajuan = PengajuanSurat::findOrFail($id);

        // Simpan status dan alasan penolakan
        $pengajuan->update([
            'status' => 'Ditolak',
            'keterangan_admin' => $request->keterangan_admin,
        ]);

        return back()->with('success', 'Permohonan surat berhasil ditolak beserta alasannya.');
    }

    // Fungsi untuk mengambil data detail via AJAX
    public function show($id)
    {
        $surat = PengajuanSurat::with(['warga', 'jenisSurat'])->findOrFail($id);

        // Kita kirim dalam bentuk JSON agar bisa ditampilkan di Modal tanpa reload
        return response()->json([
            'nama' => $surat->warga->nama_lengkap,
            'nik' => $surat->warga_nik,
            'jenis' => $surat->jenisSurat->nama_surat,
            'tanggal' => $surat->created_at->format('d F Y'),
            'updated' => $surat->updated_at->format('d F Y'),
            'status' => $surat->status,
            'metode_ambil' => $surat->metode_ambil === 'mandiri' ? 'Cetak Sendiri' : 'Ambil di Kantor',
            'nomor_surat' => $surat->nomor_surat ? $surat->nomor_surat : 'Belum ada nomor surat',
        ]);
    }

    public function cetakSurat($id)
    {
        $surat = PengajuanSurat::with([
            'warga',
            'jenisSurat',
            'penghasilanDetail',
            'sktmDetail',
            'beasiswaDetail',
            'iumkDetail',
            'belumMenikahDetail',
            'izinKeramaianDetail',
            'kehilanganDokDetail',
            'pengantarDetail',
        ])->findOrFail($id);

        if ($surat->status !== 'Disetujui') {
            return redirect()->back()->with('error', 'Surat belum disetujui.');
        }

        return app(PdfSuratService::class)->generate($surat);
    }
}
