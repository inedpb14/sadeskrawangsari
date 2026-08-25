<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panduan Pengurusan Surat - Desa Krawang Sari</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Domine:wght@400;700&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style-warga.css') }}">
    <style>
        .page-header {
            background: linear-gradient(135deg, var(--color-1), var(--color-2));
            padding: 60px 20px;
            text-align: center;
            color: white;
            margin-bottom: 50px;
        }

        .grid-panduan {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto 60px;
            padding: 0 20px;
        }

        .card-panduan {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border-top: 4px solid var(--color-2);
        }

        .card-panduan h3 {
            font-family: 'Domine', serif;
            color: var(--color-1);
            font-size: 1.3rem;
            margin-bottom: 15px;
            border-bottom: 1px dashed #eee;
            padding-bottom: 10px;
        }

        .card-panduan ul {
            padding-left: 20px;
            color: #555;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .card-panduan li {
            margin-bottom: 8px;
        }

        .btn-ajukan {
            display: block;
            text-align: center;
            background: var(--color-1);
            color: white;
            padding: 10px;
            border-radius: 8px;
            text-decoration: none;
            margin-top: 20px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-ajukan:hover {
            background: var(--color-2);
        }
    </style>
</head>

<body style="background-color: #f8f9fa;">
    @include('partials.navbar')

    <div class="page-header">
        <h1 style="font-family: 'Domine', serif; font-size: 2.5rem; margin-bottom: 10px;">Panduan Pengurusan Dokumen
        </h1>
        <p>Persiapkan berkas persyaratan berikut sebelum mengajukan permohonan surat.</p>
    </div>

    <div class="grid-panduan">
        <div class="card-panduan">
            <h3><i class="fas fa-id-card me-2"></i> Surat Pengantar KTP / KK</h3>
            <ul>
                <li>Fotokopi Kartu Keluarga (KK) Lama</li>
                <li>Fotokopi Akta Kelahiran / Ijazah Terakhir</li>
                <li>Surat Pengantar dari RT/RW setempat</li>
            </ul>
            <a href="/layanan/ajukan" class="btn-ajukan">Ajukan Sekarang</a>
        </div>

        <div class="card-panduan">
            <h3><i class="fas fa-hand-holding-heart me-2"></i> Surat Ket. Tidak Mampu (SKTM)</h3>
            <ul>
                <li>Fotokopi KTP dan Kartu Keluarga (KK)</li>
                <li>Surat Pengantar RT/RW (Menerangkan kondisi ekonomi)</li>
                <li>Foto kondisi rumah (Tampak depan & dalam)</li>
            </ul>
            <a href="/layanan/ajukan" class="btn-ajukan">Ajukan Sekarang</a>
        </div>

        <div class="card-panduan">
            <h3><i class="fas fa-map-marked-alt me-2"></i> Surat Keterangan Domisili</h3>
            <ul>
                <li>Fotokopi KTP asal / daerah sebelumnya</li>
                <li>Surat Pengantar dari RT/RW setempat</li>
                <li>Bukti kepemilikan / sewa tempat tinggal</li>
            </ul>
            <a href="/layanan/ajukan" class="btn-ajukan">Ajukan Sekarang</a>
        </div>
    </div>

    @include('partials.footer')
</body>

</html>
