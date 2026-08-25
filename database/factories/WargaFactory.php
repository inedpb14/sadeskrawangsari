<?php

namespace Database\Factories;

use App\Models\Warga;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Warga>
 */
class WargaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nik' => '327504'.fake()->unique()->numerify('##########'),
            'user_id' => null,
            'no_kk' => null,
            'nama_lengkap' => fake()->name(),
            'tempat_lahir' => fake()->city(),
            'tanggal_lahir' => fake()->dateTimeBetween('-60 years', '-17 years'),
            'jenis_kelamin' => fake()->randomElement(['L', 'P']),
            'alamat_jalan' => fake()->streetAddress(),
            'rt_rw' => fake()->numerify('##/##'),
            'kel_desa' => fake()->city(),
            'kecamatan' => fake()->city(),
            'agama' => fake()->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']),
            'status_perkawinan' => fake()->randomElement(['Kawin', 'Belum Kawin', 'Cerai Hidup', 'Cerai Mati']),
            'pekerjaan' => fake()->jobTitle(),
            'kewarganegaraan' => 'WNI',
            'no_hp' => '08'.fake()->numerify('##########'),
            'foto' => 'foto_profil/nopict.png',
            'is_active' => true,
        ];
    }
}
