<?php

namespace App\Http\Controllers\Penduduk;

use App\Http\Controllers\Controller;
use App\Models\JenisSurat;
use App\Models\PengajuanSurat;
use App\Services\PdfSuratService;
use App\Services\PengajuanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PengajuanSuratController extends Controller
{
    public function index()
    {
        return view('warga.pengajuan.katalog');
    }

    public function create($jenis)
    {
        $slug = $jenis;
        $jenis_surat_nama = str_replace('-', ' ', ucwords($jenis, '-'));

        // Resolve jenis_surat via DB using slug to kode_surat mapping
        $slugToKodeMap = [
            'surat-sktm' => 'SKTM',
            'surat-beasiswa' => 'BEAS',
            'surat-iumk' => 'IUMK',
            'surat-domisili' => 'DOMI',
            'surat-penghasilan' => 'PHSL',
            'surat-belummenikah' => 'BLMK',
            'surat-kehilangan' => 'HILG',
            'surat-kematian' => 'KMAT',
            'surat-pengantar' => 'PNTR',
            'surat-jamkes' => 'JAMK',
            'surat-keramaian' => 'IZRM',
            'surat-pindah' => 'PNDH',
            'surat-perubahandata' => 'UBDT',
        ];

        $kodeSurat = $slugToKodeMap[$slug] ?? null;
        $jenisSurat = $kodeSurat
            ? JenisSurat::where('kode_surat', $kodeSurat)->first()
            : null;

        // Fallback: try by name if slug mapping fails
        if (! $jenisSurat) {
            $jenisSurat = JenisSurat::where('nama_surat', 'like', '%'.$jenis_surat_nama.'%')->first();
        }

        $jenis_id = $jenisSurat?->id;

        // AMBIL DATA KELUARGA
        $user = Auth::guard('warga')->user();
        $anggota_keluarga = [];

        // Cek apakah user memiliki no_kk, jika ada, tarik semua warga dengan no_kk yang sama
        if ($user->no_kk) {
            $anggota_keluarga = DB::table('warga')->where('no_kk', $user->no_kk)->get();
        }

        // Tambahkan variabel anggota_keluarga ke compact()
        return view('warga.pengajuan.create', compact('jenis_surat_nama', 'slug', 'jenis_id', 'anggota_keluarga'));
    }

    public function store(Request $request)
    {
        $rules = [
            'warga_nik_pemohon' => 'required',
            'jenis_surat_id' => 'required',
            'metode_ambil' => 'required|in:kantor,mandiri',
            'slug' => 'required',
        ];

        if ($request->slug == 'surat-sktm') {
            $rules += ['tujuan_sktm' => 'required', 'jumlah_tanggungan' => 'required|integer', 'keterangan_aset' => 'required', 'total_penghasilan_keluarga' => 'required|numeric'];
        } elseif ($request->slug == 'surat-beasiswa') {
            $rules += ['nama_institusi' => 'required', 'tingkat_pendidikan' => 'required|in:SD,SMP,SMA,Perguruan Tinggi,Lainnya', 'nama_penerima_beasiswa' => 'required'];
        } elseif ($request->slug == 'surat-iumk') {
            $rules += ['nama_usaha' => 'required', 'jenis_usaha' => 'required', 'lokasi_usaha' => 'required', 'modal_usaha' => 'required|numeric'];
        } elseif ($request->slug == 'surat-domisili') {
            $rules += ['tujuan_pembuatan' => 'required'];
        } elseif ($request->slug == 'surat-penghasilan') {
            $rules += ['penghasilan_per_bulan' => 'required|numeric', 'pekerjaan_sebenarnya' => 'required|string|max:150', 'tempat_kerja' => 'required|string|max:255', 'tujuan_surat' => 'required'];
        } elseif ($request->slug == 'surat-kehilangan') {
            $rules += ['jenis_dokumen_hilang' => 'required', 'keterangan_hilang' => 'required', 'lokasi_hilang' => 'required'];
        } elseif ($request->slug == 'surat-kematian') {
            $rules += ['nik_yang_meninggal' => 'required|size:16', 'nama_yang_meninggal' => 'required', 'tanggal_kematian' => 'required', 'tempat_kematian' => 'required', 'penyebab_kematian' => 'required', 'nik_pelapor' => 'required|size:16'];
        } elseif ($request->slug == 'surat-pindah') {
            $rules += ['alamat_tujuan_lengkap' => 'required', 'alasan_pindah' => 'required', 'tgl_rencana_pindah' => 'required|date', 'jumlah_ikut_pindah' => 'required|integer'];
        } elseif ($request->slug == 'surat-belummenikah') {
            $rules += ['tujuan_permohonan' => 'required'];
        } elseif ($request->slug == 'surat-keramaian') {
            $rules += ['nama_kegiatan' => 'required', 'lokasi_kegiatan' => 'required', 'tgl_mulai' => 'required|date', 'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai', 'penanggung_jawab' => 'required'];
        } elseif ($request->slug == 'surat-pengantar') {
            $rules += ['jenis_pengantar' => 'required', 'keterangan' => 'required'];
        } elseif ($request->slug == 'surat-jamkes') {
            $rules += ['status_peserta' => 'required|in:Baru,Perpanjangan,Perubahan Data', 'program_bantuan' => 'required', 'nik_tertanggung' => 'required|size:16'];
        } elseif ($request->slug == 'surat-perubahandata') {
            $rules += ['data_lama' => 'required', 'data_baru' => 'required', 'alasan_perubahan' => 'required'];
        }

        $validated = $request->validate($rules);

        try {
            $pengajuan = app(PengajuanService::class)->createPengajuan($validated);

            return redirect()->route('dashboard.warga')->with('success', 'Pengajuan berhasil dikirim.');
        } catch (\Exception $e) {
            Log::error('Gagal simpan pengajuan: '.$e->getMessage());

            return back()->with('error', 'Gagal: '.$e->getMessage())->withInput();
        }
    }

    public function updateStatus($id, $status)
    {
        $pengajuan = PengajuanSurat::findOrFail($id);
        $pengajuan->update(['status' => $status]);

        // Jika disetujui, Anda bisa menambahkan logika notifikasi di sini
        return back()->with('success', "Status berhasil diperbarui menjadi $status.");
    }

    // Fungsi Cetak PDF (Bisa diakses Admin & Warga)
    public function cetakSurat($id)
    {
        $surat = PengajuanSurat::with([
            'warga',
            'jenisSurat',
            'penghasilanDetail',
            'sktmDetail',
            'beasiswaDetail',
            'iumkDetail',
            'domisiliDetail',
            'belumMenikahDetail',
            'izinKeramaianDetail',
            'kehilanganDokDetail',
            'pengantarDetail',
            'pengantarKtpDetail',
            'jaminanKesehatanDetail',
            'kematianDetail',
            'pindahDetail',
            'perubahanDataDetail',
        ])->findOrFail($id);

        if (! app(PdfSuratService::class)->canPrint(Auth::guard('warga')->user(), $surat)) {
            abort(403, 'Anda tidak memiliki akses ke dokumen ini.');
        }

        return app(PdfSuratService::class)->generate($surat);
    }
}
