<?php

namespace Database\Factories;

use App\Models\JenisSurat;
use App\Models\PengajuanSurat;
use App\Models\Warga;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PengajuanSurat>
 */
class PengajuanSuratFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nomor_surat' => null,
            'warga_nik' => Warga::inRandomOrder()->first()?->nik ?? '3275040000000001',
            'jenis_surat_id' => JenisSurat::inRandomOrder()->first()?->id ?? 1,
            'status' => fake()->randomElement(['Diajukan', 'Diproses', 'Disetujui', 'Ditolak']),
            'metode_ambil' => fake()->randomElement(['kantor', 'mandiri']),
            'keterangan_admin' => null,
            'final_pdf_path' => null,
            'kode_verifikasi_qr' => fake()->unique()->bothify('???####???'),
        ];
    }
}
