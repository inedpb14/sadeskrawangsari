<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kumpulan Berita - {{ $pengaturan->nama_desa ?? 'Desa Krawang Sari' }}</title>
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

        .page-header {
            background: #2c3e50;
            padding: 60px 20px;
            text-align: center;
            color: white;
            margin-bottom: 50px;
        }

        .page-header h1 {
            font-family: 'Domine', serif;
            font-size: 2.5rem;
            margin-bottom: 10px;
            color: white;
        }

        .grid-berita {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .card-berita {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: 0.3s;
            display: flex;
            flex-direction: column;
        }

        .card-berita:hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transform: translateY(-5px);
        }

        .berita-img {
            height: 200px;
            width: 100%;
            object-fit: cover;
        }

        .berita-content {
            padding: 25px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .berita-tgl {
            font-size: 0.85rem;
            color: #3a918e;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .berita-content h3 {
            font-size: 1.25rem;
            font-family: 'Domine', serif;
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .berita-content p {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 20px;
            flex-grow: 1;
        }

        .berita-link {
            color: #3a918e;
            font-weight: 600;
            text-decoration: none;
        }

        .pagination-container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 0 20px;
            display: flex;
            justify-content: center;
        }

        /* Style bawaan pagination Laravel */
        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            gap: 5px;
        }

        .page-item .page-link {
            padding: 10px 15px;
            background: white;
            border: 1px solid #ddd;
            color: #2c3e50;
            border-radius: 8px;
            text-decoration: none;
        }

        .page-item.active .page-link {
            background: #3a918e;
            color: white;
            border-color: #3a918e;
        }
    </style>
</head>

<body>
    @include('partials.navbar')

    <div class="page-header">
        <h1>Kabar & Berita Desa</h1>
        <p>Menyajikan informasi terbaru dan transparan seputar aktivitas Desa Krawang Sari.</p>
    </div>

    @if ($berita->count() > 0)
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
                        <a href="{{ route('berita.show', $item->slug) }}" class="berita-link mt-auto">Baca Selengkapnya
                            <i class="fas fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="pagination-container">
            {{ $berita->links('pagination::bootstrap-4') }}
        </div>
    @else
        <div style="text-align: center; padding: 100px 20px; color: #666;">
            <i class="fas fa-newspaper fa-4x mb-3 opacity-25"></i>
            <h3>Belum ada berita yang diterbitkan.</h3>
        </div>
    @endif

    @include('partials.footer')
</body>

</html>
