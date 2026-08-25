<?php

namespace Database\Factories;

use App\Models\PengaturanDesa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PengaturanDesa>
 */
class PengaturanDesaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_desa' => 'Desa Krawang Sari',
            'alamat' => fake()->address(),
            'telepon' => '08'.fake()->numerify('##########'),
            'email' => fake()->safeEmail(),
            'visi_misi' => '<p><strong>Visi:</strong> Desa yang mandiri dan sejahtera.</p><p><strong>Misi:</strong> Mewujudkan pelayanan prima.</p>',
            'sejarah' => '<p>Desa Krawang Sari berlokasi di Kecamatan Natar.</p>',
            'sambutan_kades' => 'Selamat datang di website Desa Krawang Sari.',
            'nama_kades' => fake()->name(),
            'foto_kades' => null,
            'hero_image' => null,
        ];
    }
}
