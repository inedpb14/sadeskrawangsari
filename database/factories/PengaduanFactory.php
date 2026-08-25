<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Pengaduan;
use App\Models\Warga;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pengaduan>
 */
class PengaduanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'warga_nik' => Warga::inRandomOrder()->first()?->nik ?? '3275040000000001',
            'kategori' => fake()->randomElement(['Infrastruktur', 'Kebersihan', 'Sosial', 'Lainnya']),
            'judul' => fake()->sentence(5),
            'isi_pengaduan' => fake()->paragraphs(3, true),
            'lampiran_path' => null,
            'status' => fake()->randomElement(['Baru', 'Diterima', 'Diproses', 'Selesai', 'Ditolak']),
            'tanggapan_admin' => null,
            'admin_id' => Admin::inRandomOrder()->first()?->id,
        ];
    }
}
