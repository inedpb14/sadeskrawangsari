<?php

namespace Database\Factories;

use App\Models\JenisSurat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<JenisSurat>
 */
class JenisSuratFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jenisSurat = [
            ['kode_surat' => 'SKTM', 'nama_surat' => 'Surat Keterangan Tidak Mampu', 'kategori' => 'Sosial'],
            ['kode_surat' => 'BEA', 'nama_surat' => 'Surat Rekomendasi Beasiswa', 'kategori' => 'Pendidikan'],
            ['kode_surat' => 'IUMK', 'nama_surat' => 'Surat IUMK', 'kategori' => 'Usaha'],
            ['kode_surat' => 'DOM', 'nama_surat' => 'Surat Keterangan Domisili', 'kategori' => 'Kependudukan'],
            ['kode_surat' => 'PENG', 'nama_surat' => 'Surat Keterangan Penghasilan', 'kategori' => 'Ekonomi'],
            ['kode_surat' => 'NIKAH', 'nama_surat' => 'Surat Keterangan Belum Menikah', 'kategori' => 'Status'],
            ['kode_surat' => 'HILANG', 'nama_surat' => 'Surat Kehilangan', 'kategori' => 'Keamanan'],
            ['kode_surat' => 'MATI', 'nama_surat' => 'Surat Kematian', 'kategori' => 'Kependudukan'],
            ['kode_surat' => 'KTP', 'nama_surat' => 'Surat Pengantar KTP', 'kategori' => 'Kependudukan'],
            ['kode_surat' => 'BPJS', 'nama_surat' => 'Surat Jaminan Kesehatan', 'kategori' => 'Kesehatan'],
            ['kode_surat' => 'RAMAI', 'nama_surat' => 'Surat Izin Keramaian', 'kategori' => 'Sosial'],
            ['kode_surat' => 'PINDAH', 'nama_surat' => 'Surat Pengantar Pindah Domisili', 'kategori' => 'Kependudukan'],
            ['kode_surat' => 'UBDT', 'nama_surat' => 'Surat Perubahan Data', 'kategori' => 'Kependudukan'],
        ];

        $data = $this->faker->randomElement($jenisSurat);

        return [
            'kode_surat' => $data['kode_surat'],
            'nama_surat' => $data['nama_surat'],
            'kategori' => $data['kategori'],
            'template_file_path' => null,
            'opsi_pengambilan' => 'keduanya',
            'deskripsi_form' => null,
            'is_active' => true,
        ];
    }
}
