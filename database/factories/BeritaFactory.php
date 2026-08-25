<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Berita;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Berita>
 */
class BeritaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(6);

        return [
            'judul' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->randomNumber(5),
            'isi' => fake()->paragraphs(5, true),
            'gambar' => null,
            'status' => fake()->randomElement(['draft', 'publish']),
            'admin_id' => Admin::inRandomOrder()->first()?->id,
        ];
    }
}
