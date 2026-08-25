<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pengaturan->nama_desa ?? 'Portal Desa Krawang Sari' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Domine:wght@400;700&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/style-warga.css') }}">

    <style>
        /* Mengamankan styling khusus landing page agar tidak bentrok */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        h1,
        h2,
        h3 {
            font-family: 'Domine', serif;
        }

        /* 1. Hero Section */
        .hero-section {
            position: relative;
            /* Menggunakan gradasi agar teks putih tetap mudah dibaca di atas gambar terang */
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.6)),
                url('{{ isset($pengaturan->hero_image) ? asset('storage/' . $pengaturan->hero_image) : 'https://images.unsplash.com/photo-1559415718-d82869275533?q=80&w=2070&auto=format&fit=crop' }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            /* Memberikan efek parallax sederhana saat di-scroll */
            height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            padding: 0 20px;
        }

        .hero-content h1 {
            color: white;
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .hero-content p {
            font-size: 1.2rem;
            font-weight: 300;
            margin-bottom: 30px;
            opacity: 0.9;
        }

        .btn-hero {
            background-color: #3a918e;
            color: white;
            padding: 15px 35px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            font-size: 1.1rem;
            transition: 0.3s;
            box-shadow: 0 4px 15px rgba(58, 145, 142, 0.4);
        }

        .btn-hero:hover {
            background-color: #2c726f;
            transform: translateY(-3px);
        }

        /* 2. Layanan Cepat (Quick Links) */
        .quick-links {
            margin-top: -60px;
            position: relative;
            z-index: 10;
            padding: 0 20px;
        }

        .grid-layanan {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .card-layanan {
            background: white;
            padding: 30px 20px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: 0.3s;
            text-decoration: none;
            color: #333;
        }

        .card-layanan:hover {
            transform: translateY(-10px);
        }

        .card-layanan i {
            font-size: 2.5rem;
            color: #3a918e;
            margin-bottom: 15px;
        }

        .card-layanan h3 {
            font-size: 1.2rem;
            margin-bottom: 10px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
        }

        .card-layanan p {
            font-size: 0.9rem;
            color: #666;
            margin: 0;
        }

        /* General Section Container */
        .section-container {
            max-width: 1200px;
            margin: 80px auto;
            padding: 0 20px;
        }

        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title h2 {
            font-size: 2.2rem;
            font-weight: 700;
            position: relative;
            display: inline-block;
            padding-bottom: 15px;
        }

        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background-color: #3a918e;
            border-radius: 2px;
        }

        /* 3. Sambutan Kades */
        .sambutan-wrapper {
            display: flex;
            align-items: center;
            gap: 50px;
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }

        .foto-kades {
            flex: 0 0 300px;
        }

        .foto-kades img {
            width: 100%;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .teks-sambutan h3 {
            font-size: 1.8rem;
            margin-bottom: 20px;
        }

        .teks-sambutan p {
            color: #555;
            line-height: 1.8;
            font-size: 1.05rem;
        }

        .nama-kades {
            margin-top: 20px;
            font-weight: 700;
            color: #2c3e50;
            font-size: 1.2rem;
        }

        /* 4. Berita */
        .grid-berita {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .card-berita {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: 0.3s;
        }

        .card-berita:hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .berita-img {
            height: 200px;
            background-color: #eee;
            width: 100%;
            object-fit: cover;
        }

        .berita-content {
            padding: 25px;
        }

        .berita-tgl {
            font-size: 0.85rem;
            color: #3a918e;
            font-weight: 600;
            display: block;
            margin-bottom: 10px;
        }

        .berita-content h3 {
            font-size: 1.25rem;
            margin-bottom: 15px;
            line-height: 1.4;
        }

        .berita-content p {
            color: #666;
            font-size: 0.95rem;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .berita-link {
            color: #3a918e;
            font-weight: 600;
            text-decoration: none;
            font-size: 0.95rem;
        }

        .berita-link:hover {
            text-decoration: underline;
        }

        /* 5. Visi Misi (Modern Split Layout) */
        .visi-misi-wrapper {
            display: flex;
            flex-direction: column;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            margin-bottom: 80px;
        }

        .visi-misi-header {
            /* Menggunakan gradasi dari color-1 ke color-2 */
            background: linear-gradient(135deg, var(--color-1), var(--color-2));
            color: white;
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
        }

        .visi-misi-header i {
            font-size: 3.5rem;
            margin-bottom: 20px;
            color: var(--color-4);
            /* Aksen warna kuning/terang Anda */
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.2));
        }

        .visi-misi-header h2 {
            color: white;
            margin-bottom: 10px;
            font-size: 2.2rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .visi-misi-header p {
            opacity: 0.9;
            margin: 0;
            font-size: 1rem;
            max-width: 250px;
        }

        .visi-misi-content {
            padding: 40px;
            flex: 1;
            position: relative;
            background: white;
        }

        .bg-quote {
            position: absolute;
            top: 20px;
            right: 30px;
            font-size: 5rem;
            color: var(--color-2);
            opacity: 0.05;
            z-index: 0;
        }

        /* Format khusus untuk tulisan dari CKEditor agar lebih rapi */
        .visi-misi-content .konten-text {
            position: relative;
            z-index: 1;
            color: #444;
            line-height: 1.8;
            font-size: 1.05rem;
            text-align: left;
            /* Rata kiri agar poin-poin mudah dibaca */
        }

        .visi-misi-content .konten-text p {
            margin-bottom: 15px;
        }

        .visi-misi-content .konten-text ul,
        .visi-misi-content .konten-text ol {
            padding-left: 20px;
            margin-bottom: 20px;
        }

        .visi-misi-content .konten-text li {
            margin-bottom: 10px;
        }

        .visi-misi-content .konten-text li::marker {
            color: var(--color-2);
            font-weight: bold;
        }

        /* Tampilan Desktop (Kiri-Kanan) */
        @media (min-width: 992px) {
            .visi-misi-wrapper {
                flex-direction: row;
            }

            .visi-misi-header {
                flex: 0 0 35%;
                /* Mengambil 35% lebar layar */
            }

            .visi-misi-content {
                padding: 60px 50px;
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2.2rem;
            }

            .sambutan-wrapper {
                flex-direction: column;
                text-align: center;
                padding: 30px 20px;
            }

            .foto-kades {
                flex: auto;
                max-width: 250px;
                margin: 0 auto;
            }
        }

        /* 6. Suara Warga (Keluhan) */
        .card-keluhan {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border-top: 4px solid #1cc88a;
            /* Warna hijau penanda selesai */
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .keluhan-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .pelapor-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .pelapor-avatar {
            width: 40px;
            height: 40px;
            background: #eef2f7;
            color: #2c3e50;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .tanggapan-admin {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            border-left: 3px solid #3a918e;
            margin-top: 15px;
            font-size: 0.9rem;
            color: #555;
            flex-grow: 1;
        }
    </style>
</head>

<body>

    @include('partials.navbar')

    <section class="hero-section">
        <div class="hero-content">
            <h1>Selamat Datang di Portal Resmi<br>{{ $pengaturan->nama_desa ?? 'Desa Krawang Sari' }}</h1>
            <p>Melayani masyarakat dengan Cepat, Transparan, dan Terpercaya secara digital.</p>
            <a href="/layanan/ajukan" class="btn-hero"><i class="fas fa-file-signature me-2"></i> Ajukan Surat
                Sekarang</a>
        </div>
    </section>

    <section class="quick-links">
        <div class="grid-layanan">
            <a href="/layanan/panduan" class="card-layanan">
                <i class="fas fa-book-open"></i>
                <h3>Panduan Layanan</h3>
                <p>Syarat & cara pengurusan dokumen.</p>
            </a>
            <a href="/layanan/ajukan" class="card-layanan">
                <i class="fas fa-laptop-house"></i>
                <h3>Layanan Surat Online</h3>
                <p>Buat permohonan surat dari rumah.</p>
            </a>
            <a href="/layanan/status" class="card-layanan">
                <i class="fas fa-search"></i>
                <h3>Cek Status Surat</h3>
                <p>Lacak progres surat yang diajukan.</p>
            </a>
        </div>
    </section>

    <section class="section-container">
        <div class="sambutan-wrapper">
            <div class="foto-kades">
                @if (isset($pengaturan->foto_kades))
                    <img src="{{ asset('storage/' . $pengaturan->foto_kades) }}" alt="Foto Kepala Desa">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($pengaturan->nama_kades ?? 'Kepala Desa') }}&size=300&background=eef2f7&color=2c3e50"
                        alt="Kepala Desa">
                @endif
            </div>
            <div class="teks-sambutan">
                <h3 style="font-family: 'Domine', serif;">Sambutan Kepala Desa</h3>
                @if (isset($pengaturan->sambutan_kades) && $pengaturan->sambutan_kades != '')
                    <div class="konten-text">
                        {!! $pengaturan->sambutan_kades !!}
                    </div>
                @else
                    <p>Selamat datang di website resmi Desa Krawang Sari. Website ini hadir sebagai wujud transparansi
                        dan inovasi pelayanan publik demi mewujudkan tata kelola desa yang lebih baik. Melalui layanan
                        mandiri ini, kami berharap warga dapat dengan mudah mengurus keperluan administrasi.</p>
                @endif
                <div class="nama-kades">
                    {{ $pengaturan->nama_kades ?? 'Bapak Kepala Desa' }}<br>
                    <span style="font-size: 0.9rem; color: #888; font-weight: 400;">Kepala
                        {{ $pengaturan->nama_desa ?? 'Desa Krawang Sari' }}</span>
                </div>
            </div>
        </div>
    </section>

    <section class="section-container">
        <div class="section-title">
            <h2>Kabar Desa Terbaru</h2>
            <p class="text-muted">Informasi dan pengumuman terkini seputar aktivitas desa.</p>
        </div>

        @if (isset($berita) && $berita->count() > 0)
            <div class="grid-berita">
                @foreach ($berita as $item)
                    <div class="card-berita">
                        <img src="{{ !empty($item->gambar) ? asset('storage/' . $item->gambar) : 'https://images.unsplash.com/photo-1585829365295-ab7cd400c167?w=500&auto=format&fit=crop' }}"
                            alt="Berita" class="berita-img">
                        <div class="berita-content">
                            <span class="berita-tgl"><i class="far fa-calendar-alt me-1"></i>
                                {{ $item->created_at->translatedFormat('d F Y') }}</span>
                            <h3>{{ $item->judul }}</h3>
                            <p>{{ Str::limit(strip_tags($item->isi), 120) }}</p>
                            <a href="{{ route('berita.show', $item->slug) }}" class="berita-link">Baca Selengkapnya <i
                                    class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div style="text-align: center; margin-top: 50px;">
                <a href="{{ route('berita.index') }}"
                    style="background-color: #2c3e50; color: white; padding: 12px 30px; border-radius: 50px; text-decoration: none; font-weight: 600; transition: 0.3s; display: inline-block;">
                    Lihat Semua Berita <i class="fas fa-newspaper ms-2"></i>
                </a>
            </div>
        @else
            <div class="text-center text-muted" style="background: white; padding: 40px; border-radius: 15px;">
                <i class="fas fa-newspaper fa-3x mb-3 opacity-25"></i>
                <p>Belum ada kabar atau pengumuman terbaru.</p>
            </div>
        @endif
    </section>

    <section class="section-container">
        <div class="section-title">
            <h2>Suara Warga (Telah Ditindaklanjuti)</h2>
            <p class="text-muted">Transparansi penyelesaian aspirasi dan pengaduan masyarakat desa.</p>
        </div>

        @if (isset($keluhan_selesai) && $keluhan_selesai->count() > 0)
            <div class="grid-berita">
                @foreach ($keluhan_selesai as $item)
                    <div class="card-keluhan">
                        <div class="keluhan-header">
                            <div class="pelapor-info">
                                <div class="pelapor-avatar">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div>
                                    {{-- Privasi: Kita samarkan sedikit nama belakang pelapor --}}
                                    @php
                                        $nama = $item->warga->nama_lengkap ?? 'Anonim';
                                        $nama_samaran = strlen($nama) > 5 ? substr($nama, 0, 4) . '***' : $nama;
                                    @endphp
                                    <div style="font-weight: 600; color: #2c3e50; font-size: 0.95rem;">
                                        {{ $nama_samaran }}</div>
                                    <div style="font-size: 0.8rem; color: #888;">
                                        {{ $item->updated_at->diffForHumans() }}</div>
                                </div>
                            </div>
                            <span class="badge"
                                style="background: #e3fbed; color: #1cc88a; padding: 5px 10px; border-radius: 20px; font-size: 0.75rem;"><i
                                    class="fas fa-check-circle me-1"></i> Selesai</span>
                        </div>
                        <h4 style="font-size: 1.1rem; margin-bottom: 10px; color: #333;">{{ $item->judul }}</h4>
                        <p style="font-size: 0.9rem; color: #666; margin-bottom: 0;">
                            {{ Str::limit($item->isi_pengaduan, 100) }}</p>

                        @if ($item->tanggapan_admin)
                            <div class="tanggapan-admin">
                                <strong style="color: #3a918e; display: block; margin-bottom: 5px;"><i
                                        class="fas fa-reply me-1"></i> Respon Desa:</strong>
                                {{ Str::limit($item->tanggapan_admin, 120) }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <div style="text-align: center; margin-top: 70px;">
                <a href="{{ route('keluhan') }}"
                    style="background-color: #f8f9fa; color: #2c3e50; border: 2px solid #2c3e50; padding: 12px 30px; border-radius: 50px; text-decoration: none; font-weight: 600; transition: 0.3s; display: inline-block;">
                    Lihat Seluruh Laporan <i class="fas fa-bullhorn ms-2"></i>
                </a>
            </div>
        @else
            <div class="text-center text-muted" style="background: white; padding: 40px; border-radius: 15px;">
                <i class="fas fa-inbox fa-3x mb-3 opacity-25"></i>
                <p>Belum ada laporan keluhan yang masuk atau diselesaikan uji.</p>
            </div>
        @endif
    </section>

    <section class="section-container">
        <div class="visi-misi-wrapper shadow-lg">
            <div class="visi-misi-header">
                <i class="fas fa-bullseye"></i>
                <h2>Visi & Misi</h2>
                <p>Arah dan tujuan pembangunan desa untuk masa depan yang lebih baik.</p>
            </div>
            <div class="visi-misi-content">
                <i class="fas fa-quote-left bg-quote"></i>
                @if (isset($pengaturan->visi_misi) && $pengaturan->visi_misi != '')
                    <div class="konten-text">
                        {!! $pengaturan->visi_misi !!}
                    </div>
                @else
                    <p class="text-muted text-center py-4"><em>Konten Visi & Misi belum tersedia.</em></p>
                @endif
            </div>
        </div>
    </section>

    @include('partials.footer')

</body>

</html>
