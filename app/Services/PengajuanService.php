<?php

namespace App\Services;

use App\Models\PengajuanSurat;
use Illuminate\Support\Facades\DB;

class PengajuanService
{
    protected $detailFields = [
        'surat-sktm' => ['tujuan_sktm', 'jumlah_tanggungan', 'keterangan_aset', 'total_penghasilan_keluarga'],
        'surat-beasiswa' => ['nama_institusi', 'tingkat_pendidikan', 'nama_penerima_beasiswa'],
        'surat-iumk' => ['nama_usaha', 'jenis_usaha', 'lokasi_usaha', 'modal_usaha'],
        'surat-domisili' => ['tujuan_pembuatan'],
        'surat-penghasilan' => ['penghasilan_per_bulan', 'pekerjaan_sebenarnya', 'tempat_kerja', 'tujuan_surat'],
        'surat-kehilangan' => ['jenis_dokumen_hilang', 'keterangan_hilang', 'lokasi_hilang'],
        'surat-kematian' => ['nik_yang_meninggal', 'nama_yang_meninggal', 'tanggal_kematian', 'tempat_kematian', 'penyebab_kematian', 'nik_pelapor'],
        'surat-pindah' => ['alamat_tujuan_lengkap', 'alasan_pindah', 'tgl_rencana_pindah', 'jumlah_ikut_pindah'],
        'surat-belummenikah' => ['tujuan_permohonan'],
        'surat-keramaian' => ['nama_kegiatan', 'lokasi_kegiatan', 'tgl_mulai', 'tgl_selesai', 'penanggung_jawab'],
        'surat-pengantar' => ['jenis_pengantar', 'keterangan'],
        'surat-jamkes' => ['status_peserta', 'program_bantuan', 'nik_tertanggung'],
        'surat-perubahandata' => ['data_lama', 'data_baru', 'alasan_perubahan'],
    ];

    protected $detailTables = [
        'surat-pindah' => 'surat_pindah_domisili_detail',
        'surat-perubahandata' => 'surat_perubahan_data_detail',
    ];

    public function createPengajuan(array $validated): PengajuanSurat
    {
        DB::beginTransaction();

        try {
            $pengajuan = PengajuanSurat::create([
                'warga_nik' => $validated['warga_nik_pemohon'],
                'jenis_surat_id' => $validated['jenis_surat_id'],
                'status' => 'Diajukan',
                'metode_ambil' => $validated['metode_ambil'],
            ]);

            $slug = $validated['slug'];
            $fields = $this->detailFields[$slug] ?? [];

            $detailData = array_intersect_key($validated, array_flip($fields));
            $detailData['pengajuan_id'] = $pengajuan->id;
            $detailData['created_at'] = now();
            $detailData['updated_at'] = now();

            $tableName = $this->detailTables[$slug] ?? str_replace('-', '_', $slug).'_detail';
            DB::table($tableName)->insert($detailData);

            DB::commit();

            return $pengajuan;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
