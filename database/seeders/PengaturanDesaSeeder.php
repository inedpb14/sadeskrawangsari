<?php

namespace Database\Seeders;

use App\Models\PengaturanDesa;
use Illuminate\Database\Seeder;

class PengaturanDesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PengaturanDesa::updateOrCreate(
            ['id' => 1],
            [
                'nama_desa' => 'Desa Krawang Sari',
                'alamat' => 'Jl. Raya Krawang Sari No. 1, Kecamatan Natar, Kabupaten Lampung Selatan',
                'telepon' => '(0721) 123456',
                'email' => 'krawangsari@desa.go.id',
                'visi_misi' => '<p><strong>Visi:</strong> "Terwujudnya Desa Krawang Sari yang Mandiri, Inovatif, Sejahtera, dan Agamis Berlandaskan Semangat Gotong Royong."</p><p><strong>Misi:</strong></p><p><strong>Peningkatan Kualitas Pelayanan:</strong> Mewujudkan tata kelola pemerintahan desa yang baik <i>(Good Governance)</i>, transparan, dan responsif melalui pemanfaatan teknologi informasi.</p><p><strong>Pemberdayaan Ekonomi Warga:</strong> Meningkatkan kesejahteraan masyarakat melalui pemberdayaan sektor pertanian, peternakan, dan Usaha Mikro Kecil dan Menengah (UMKM) lokal.</p><p><strong>Pembangunan Infrastruktur:</strong> Meningkatkan pembangunan sarana dan prasarana fisik desa yang adil, merata, dan berkelanjutan guna menunjang mobilitas dan perekonomian warga.</p><p><strong>Peningkatan Kualitas SDM:</strong> Mendukung program pendidikan dan kesehatan untuk menciptakan generasi Krawang Sari yang cerdas, sehat, dan berakhlak mulia.</p><p><strong>Pelestarian Lingkungan & Budaya:</strong> Menjaga kelestarian lingkungan hidup serta memelihara nilai-nilai agama, sosial, dan budaya luhur yang ada di masyarakat Kecamatan Natar.</p>',
                'sejarah' => '<p>Desa Krawang Sari adalah salah satu desa yang terletak di Kecamatan Natar, Kabupaten Lampung Selatan, Provinsi Lampung. Secara etimologi, penamaan "Krawang Sari" diambil dari filosofi dan harapan para pendiri desa. Kata <i>Sari</i> bermakna inti atau kejayaan, yang melambangkan doa dan harapan agar wilayah ini menjadi tanah yang subur, makmur, dan memberikan kesejahteraan bagi setiap penduduk yang mendiaminya.</p><p>Pada masa awal pembentukannya, wilayah Krawang Sari mulanya adalah kawasan hutan dan perkebunan yang secara bertahap mulai dibuka oleh kelompok masyarakat perintis yang datang mencari penghidupan baru. Seiring berjalannya waktu, wilayah ini terus mengalami pertumbuhan penduduk yang signifikan, baik dari masyarakat pribumi Lampung maupun para pendatang dari berbagai daerah yang hidup berdampingan secara harmonis.</p>',
                'sambutan_kades' => 'Assalamu\'alaikum Warahmatullahi Wabarakatuh. Selamat datang di website resmi Desa Krawang Sari. Website ini kami hadirkan sebagai wujud komitmen Pemerintah Desa dalam mewujudkan pelayanan publik yang transparan, akuntabel, dan berbasis teknologi informasi. Semoga website ini bermanfaat bagi kita semua. Wassalamu\'alaikum Warahmatullahi Wabarakatuh.',
                'nama_kades' => 'Bapak Kepala Desa',
                'foto_kades' => null,
                'hero_image' => null,
            ]
        );

        $this->command->info('Pengaturan desa berhasil di-seed');
    }
}
