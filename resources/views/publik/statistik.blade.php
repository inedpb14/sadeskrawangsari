<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistik Penduduk - Desa Krawang Sari</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Domine:wght@400;700&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style-warga.css') }}">
    <style>
        .page-header {
            background: #2c3e50;
            padding: 60px 20px;
            text-align: center;
            color: white;
            margin-bottom: 50px;
        }

        .stats-wrapper {
            max-width: 1000px;
            margin: -80px auto 60px;
            padding: 0 20px;
        }

        .grid-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            padding: 30px 20px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .stat-card h3 {
            font-size: 2.5rem;
            color: var(--color-1);
            margin: 10px 0 0;
            font-family: 'Domine', serif;
        }

        .stat-card p {
            color: #888;
            font-size: 0.9rem;
            margin: 0;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .chart-box {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .chart-box h4 {
            font-family: 'Domine', serif;
            color: var(--color-1);
            border-bottom: 2px solid #eee;
            padding-bottom: 15px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>

<body style="background-color: #f8f9fa;">
    @include('partials.navbar')

    <div class="page-header">
        <h1 style="font-family: 'Domine', serif; font-size: 2.5rem; margin-bottom: 10px;">Statistik Demografi Desa</h1>
        <p>Transparansi data kependudukan Desa Krawang Sari yang terintegrasi secara langsung.</p>
    </div>

    <div class="stats-wrapper">
        <div class="grid-stats">
            <div class="stat-card">
                <i class="fas fa-users fa-3x" style="color: var(--color-2);"></i>
                <h3>{{ number_format($stats['total']) }}</h3>
                <p>Total Penduduk</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-male fa-3x" style="color: #476eae;"></i>
                <h3>{{ number_format($stats['laki_laki']) }}</h3>
                <p>Laki-Laki</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-female fa-3x" style="color: #e83e8c;"></i>
                <h3>{{ number_format($stats['perempuan']) }}</h3>
                <p>Perempuan</p>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 30px;">
            <div class="chart-box">
                <h4>Rasio Jenis Kelamin</h4>
                <div style="height: 300px;"><canvas id="genderChart"></canvas></div>
            </div>
            <div class="chart-box">
                <h4>Distribusi Kelompok Usia</h4>
                <div style="height: 300px;"><canvas id="ageChart"></canvas></div>
            </div>
        </div>
    </div>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Chart Jenis Kelamin
        new Chart(document.getElementById('genderChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: ['Laki-laki', 'Perempuan'],
                datasets: [{
                    data: [{{ $stats['laki_laki'] }}, {{ $stats['perempuan'] }}],
                    backgroundColor: ['#476eae', '#e83e8c'],
                    borderWidth: 2
                }]
            },
            options: {
                maintainAspectRatio: false
            }
        });

        // Chart Rentang Usia
        new Chart(document.getElementById('ageChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Anak (< 17 Thn)', 'Dewasa (17-59 Thn)', 'Lansia (> 60 Thn)'],
                datasets: [{
                    label: 'Jumlah Jiwa',
                    data: [{{ $stats['anak'] }}, {{ $stats['dewasa'] }}, {{ $stats['lansia'] }}],
                    backgroundColor: 'var(--color-2)',
                    borderRadius: 5
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
</body>

</html>
