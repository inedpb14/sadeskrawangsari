<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $berita->judul }} - Desa Krawang Sari</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Domine:wght@400;700&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style-warga.css') }}">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .berita-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
            display: flex;
            gap: 40px;
            align-items: flex-start;
        }

        /* Kiri: Konten Utama */
        .main-content {
            flex: 1;
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }

        .breadcrumb {
            font-size: 0.9rem;
            margin-bottom: 20px;
            color: #666;
        }

        .breadcrumb a {
            color: #3a918e;
            text-decoration: none;
        }

        .berita-title {
            font-family: 'Domine', serif;
            font-size: 2.2rem;
            color: #2c3e50;
            margin-bottom: 15px;
            line-height: 1.4;
        }

        .berita-meta {
            display: flex;
            gap: 20px;
            font-size: 0.9rem;
            color: #888;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }

        .berita-meta span {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .berita-cover {
            width: 100%;
            max-height: 450px;
            object-fit: cover;
            border-radius: 15px;
            margin-bottom: 30px;
        }

        .berita-body {
            font-size: 1.05rem;
            line-height: 1.8;
            color: #444;
        }

        .berita-body img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin: 15px 0;
        }

        /* Kanan: Sidebar Navigasi */
        .sidebar {
            width: 350px;
            flex-shrink: 0;
            position: sticky;
            top: 20px;
        }

        .sidebar-box {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }

        .sidebar-title {
            font-family: 'Domine', serif;
            font-size: 1.2rem;
            color: #2c3e50;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #3a918e;
            display: inline-block;
        }

        .list-berita-lain {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .item-berita {
            display: flex;
            gap: 15px;
            text-decoration: none;
            color: inherit;
            transition: 0.2s;
        }

        .item-berita:hover .item-judul {
            color: #3a918e;
        }

        .item-img {
            width: 90px;
            height: 75px;
            border-radius: 8px;
            object-fit: cover;
            flex-shrink: 0;
        }

        .item-info {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .item-judul {
            font-size: 0.95rem;
            font-weight: 600;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .item-tgl {
            font-size: 0.8rem;
            color: #888;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .berita-container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                position: static;
            }
        }

        @media (max-width: 768px) {
            .berita-title {
                font-size: 1.8rem;
            }

            .main-content {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    @include('partials.navbar')

    <div class="berita-container">
        <main class="main-content">
            <div class="breadcrumb">
                <a href="/"><i class="fas fa-home"></i> Beranda</a> <i class="fas fa-chevron-right mx-2"
                    style="font-size: 0.7rem; opacity: 0.5;"></i>
                <a href="{{ route('berita.index') }}">Berita</a> <i class="fas fa-chevron-right mx-2"
                    style="font-size: 0.7rem; opacity: 0.5;"></i>
                <span style="color: #333;">Membaca Artikel</span>
            </div>

            <h1 class="berita-title">{{ $berita->judul }}</h1>

            <div class="berita-meta">
                <span><i class="fas fa-calendar-alt text-primary"></i>
                    {{ $berita->created_at->translatedFormat('l, d F Y') }}</span>
                <span><i class="fas fa-user-edit text-primary"></i> Oleh:
                    {{ $berita->admin->nama ?? 'Admin Desa' }}</span>
            </div>

            <img src="{{ !empty($berita->gambar) ? asset('storage/' . $berita->gambar) : 'https://images.unsplash.com/photo-1585829365295-ab7cd400c167' }}"
                alt="Cover Berita" class="berita-cover">

            <div class="berita-body">
                {!! $berita->isi !!}
            </div>

            <div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #eee;">
                <a href="{{ route('berita.index') }}" style="color: #3a918e; text-decoration: none; font-weight: 600;">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Indeks Berita
                </a>
            </div>
        </main>

        <aside class="sidebar">
            <div class="sidebar-box">
                <h3 class="sidebar-title">Kabar Lainnya</h3>
                <div class="list-berita-lain">
                    @forelse ($berita_lain as $lain)
                        <a href="{{ route('berita.show', $lain->slug) }}" class="item-berita">
                            <img src="{{ !empty($lain->gambar) ? asset('storage/' . $lain->gambar) : 'https://images.unsplash.com/photo-1585829365295-ab7cd400c167' }}"
                                alt="Thumb" class="item-img">
                            <div class="item-info">
                                <span class="item-judul">{{ $lain->judul }}</span>
                                <span class="item-tgl"><i class="far fa-clock"></i>
                                    {{ $lain->created_at->diffForHumans() }}</span>
                            </div>
                        </a>
                    @empty
                        <p class="text-muted small">Belum ada berita lainnya.</p>
                    @endforelse
                </div>
            </div>
        </aside>
    </div>

    @include('partials.footer')
</body>

</html>
