<?php

namespace Database\Seeders;

use App\Models\JenisSurat;
use Illuminate\Database\Seeder;

class JenisSuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenisSurat = [
            ['kode_surat' => 'SKTM', 'nama_surat' => 'Surat Keterangan Tidak Mampu', 'kategori' => 'Sosial', 'opsi_pengambilan' => 'keduanya'],
            ['kode_surat' => 'BEA', 'nama_surat' => 'Surat Rekomendasi Beasiswa', 'kategori' => 'Pendidikan', 'opsi_pengambilan' => 'keduanya'],
            ['kode_surat' => 'IUMK', 'nama_surat' => 'Surat IUMK', 'kategori' => 'Usaha', 'opsi_pengambilan' => 'keduanya'],
            ['kode_surat' => 'DOM', 'nama_surat' => 'Surat Keterangan Domisili', 'kategori' => 'Kependudukan', 'opsi_pengambilan' => 'keduanya'],
            ['kode_surat' => 'PENG', 'nama_surat' => 'Surat Keterangan Penghasilan', 'kategori' => 'Ekonomi', 'opsi_pengambilan' => 'keduanya'],
            ['kode_surat' => 'NIKAH', 'nama_surat' => 'Surat Keterangan Belum Menikah', 'kategori' => 'Status', 'opsi_pengambilan' => 'keduanya'],
            ['kode_surat' => 'HILANG', 'nama_surat' => 'Surat Kehilangan', 'kategori' => 'Keamanan', 'opsi_pengambilan' => 'keduanya'],
            ['kode_surat' => 'MATI', 'nama_surat' => 'Surat Kematian', 'kategori' => 'Kependudukan', 'opsi_pengambilan' => 'keduanya'],
            ['kode_surat' => 'KTP', 'nama_surat' => 'Surat Pengantar KTP', 'kategori' => 'Kependudukan', 'opsi_pengambilan' => 'keduanya'],
            ['kode_surat' => 'BPJS', 'nama_surat' => 'Surat Jaminan Kesehatan', 'kategori' => 'Kesehatan', 'opsi_pengambilan' => 'keduanya'],
            ['kode_surat' => 'RAMAI', 'nama_surat' => 'Surat Izin Keramaian', 'kategori' => 'Sosial', 'opsi_pengambilan' => 'keduanya'],
            ['kode_surat' => 'PINDAH', 'nama_surat' => 'Surat Pengantar Pindah Domisili', 'kategori' => 'Kependudukan', 'opsi_pengambilan' => 'keduanya'],
            ['kode_surat' => 'UBDT', 'nama_surat' => 'Surat Perubahan Data', 'kategori' => 'Kependudukan', 'opsi_pengambilan' => 'keduanya'],
        ];

        foreach ($jenisSurat as $surat) {
            JenisSurat::updateOrCreate(
                ['kode_surat' => $surat['kode_surat']],
                array_merge($surat, [
                    'template_file_path' => null,
                    'deskripsi_form' => null,
                    'is_active' => true,
                ])
            );
        }

        $this->command->info('Jenis surat berhasil di-seed: '.count($jenisSurat).' data');
    }
}
