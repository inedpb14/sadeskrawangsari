<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sejarah & Wilayah - Desa Krawang Sari</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Domine:wght@400;700&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style-warga.css') }}">
    <style>
        .page-header {
            background: linear-gradient(135deg, var(--color-1), var(--color-2));
            padding: 80px 20px;
            text-align: center;
            color: white;
            margin-bottom: 40px;
        }

        .page-header h1 {
            font-family: 'Domine', serif;
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .content-box {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            max-width: 1000px;
            margin: -80px auto 50px;
            position: relative;
            line-height: 1.8;
            color: #444;
        }

        .content-box img {
            max-width: 100%;
            border-radius: 10px;
            margin: 20px 0;
        }
    </style>
</head>

<body style="background-color: #f8f9fa;">
    @include('partials.navbar')

    <div class="page-header">
        <h1>Sejarah & Wilayah Desa</h1>
        <p>Mengenal lebih dekat asal-usul dan kondisi geografis Desa Krawang Sari.</p>
    </div>

    <div class="content-box">
        @if (isset($pengaturan->visi_misi) && $pengaturan->visi_misi != '')
            <div class="konten-text">
                {!! $pengaturan->visi_misi !!}
            </div>
        @else
            <div class="text-center text-muted py-5">
                <i class="fas fa-history fa-4x opacity-25 mb-3"></i>
                <p>Data sejarah dan profil wilayah desa sedang dalam tahap pembaruan oleh admin.</p>
            </div>
        @endif
    </div>

    @include('partials.footer')
</body>

</html>
