<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suara Warga - {{ $pengaturan->nama_desa ?? 'Desa Krawang Sari' }}</title>
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
            margin-bottom: 40px;
        }

        .page-header h1 {
            font-family: 'Domine', serif;
            font-size: 2.5rem;
            margin-bottom: 10px;
            color: white;
        }

        /* Statistik Publik */
        .stats-container {
            max-width: 900px;
            margin: -80px auto 40px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            padding: 0 20px;
        }

        .stat-box {
            background: white;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .stat-box h3 {
            font-size: 2rem;
            color: #2c3e50;
            margin: 10px 0 0;
        }

        .stat-box p {
            color: #888;
            font-size: 0.9rem;
            margin: 0;
            text-transform: uppercase;
            font-weight: 600;
        }

        .grid-keluhan {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .card-keluhan {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
        }

        .badge-status {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .bg-menunggu {
            background: #fff3cd;
            color: #856404;
        }

        .bg-diproses {
            background: #d1ecf1;
            color: #0c5460;
        }

        .bg-selesai {
            background: #d4edda;
            color: #155724;
        }

        .bg-ditolak {
            background: #f8d7da;
            color: #721c24;
        }

        .tanggapan-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin-top: 15px;
            font-size: 0.9rem;
            color: #555;
            flex-grow: 1;
            border-left: 3px solid #ccc;
        }

        .tanggapan-box.responded {
            border-left-color: #3a918e;
            background: #f0fbfb;
        }

        .pagination-container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 0 20px;
            display: flex;
            justify-content: center;
        }

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

        @media (max-width: 768px) {
            .stats-container {
                grid-template-columns: 1fr;
                margin-top: 0;
            }
        }
    </style>
</head>

<body>
    @include('partials.navbar')

    <div class="page-header">
        <h1>Suara Warga Desa</h1>
        <p>Transparansi pelaporan, kritik, dan saran dari masyarakat untuk kemajuan desa bersama.</p>
    </div>

    <div class="stats-container">
        <div class="stat-box">
            <i class="fas fa-inbox fa-2x text-primary"></i>
            <h3>{{ $stats['total'] }}</h3>
            <p>Total Laporan</p>
        </div>
        <div class="stat-box">
            <i class="fas fa-tools fa-2x text-info"></i>
            <h3>{{ $stats['diproses'] }}</h3>
            <p>Sedang Diproses</p>
        </div>
        <div class="stat-box">
            <i class="fas fa-check-circle fa-2x text-success"></i>
            <h3 class="text-success">{{ $stats['selesai'] }}</h3>
            <p>Telah Selesai</p>
        </div>
    </div>

    @if ($keluhan->count() > 0)
        <div class="grid-keluhan">
            @foreach ($keluhan as $item)
                <div class="card-keluhan">
                    <div
                        style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
                        <div>
                            @php
                                $nama = $item->warga->nama_lengkap ?? 'Anonim';
                                $nama_samaran = strlen($nama) > 5 ? substr($nama, 0, 4) . '***' : $nama;
                            @endphp
                            <div style="font-weight: 600; color: #2c3e50;"><i class="fas fa-user-circle me-1"></i>
                                {{ $nama_samaran }}</div>
                            <div style="font-size: 0.8rem; color: #888;">
                                {{ $item->created_at->translatedFormat('d M Y, H:i') }}</div>
                        </div>

                        @if ($item->status == 'Menunggu')
                            <span class="badge-status bg-menunggu">Menunggu</span>
                        @elseif($item->status == 'Diproses')
                            <span class="badge-status bg-diproses">Diproses</span>
                        @elseif($item->status == 'Selesai')
                            <span class="badge-status bg-selesai">Selesai</span>
                        @else
                            <span class="badge-status bg-ditolak">Ditolak</span>
                        @endif
                    </div>

                    <span
                        style="font-size: 0.8rem; background: #eee; padding: 3px 8px; border-radius: 5px; display: inline-block; width: max-content; margin-bottom: 10px;">{{ $item->kategori }}</span>
                    <h4 style="font-size: 1.1rem; color: #333; margin-bottom: 10px;">{{ $item->judul }}</h4>
                    <p style="font-size: 0.95rem; color: #666; line-height: 1.6; margin-bottom: 0;">
                        {{ $item->isi_pengaduan }}</p>

                    @if ($item->lampiran_path)
                        <a href="{{ asset('storage/' . $item->lampiran_path) }}" target="_blank"
                            style="font-size: 0.85rem; color: #3a918e; text-decoration: none; display: block; margin-top: 10px;">
                            <i class="fas fa-paperclip me-1"></i> Lihat Bukti Lampiran
                        </a>
                    @endif

                    <div class="tanggapan-box {{ $item->tanggapan_admin ? 'responded' : '' }}">
                        @if ($item->tanggapan_admin)
                            <strong style="color: #3a918e; display: block; margin-bottom: 5px;"><i
                                    class="fas fa-reply me-1"></i> Tanggapan Desa:</strong>
                            {{ $item->tanggapan_admin }}
                        @else
                            <em style="color: #999;"><i class="fas fa-hourglass-half me-1"></i> Belum ada tanggapan
                                resmi dari pihak desa.</em>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="pagination-container">
            {{ $keluhan->links('pagination::bootstrap-4') }}
        </div>
    @else
        <div style="text-align: center; padding: 100px 20px; color: #666;">
            <i class="fas fa-inbox fa-4x mb-3 opacity-25"></i>
            <h3>Belum ada aspirasi atau keluhan yang masuk.</h3>
        </div>
    @endif

    @include('partials.footer')
</body>

</html>
