<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    {{-- Title dibuat dinamis agar bisa berubah sesuai jenis surat --}}
    <title>@yield('title') - {{ $surat->warga->nama_lengkap }}</title>
    <style>
        @page {
            margin: 1cm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 10px 30px;
        }

        /* Kop Surat */
        .kop-tabel {
            width: 100%;
            border-bottom: 3px double #000;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }

        .logo-img {
            width: 80px;
        }

        .kop-text {
            text-align: center;
        }

        .kop-text h3 {
            margin: 0;
            font-size: 14pt;
            font-weight: normal;
        }

        .kop-text h2 {
            margin: 0;
            font-size: 16pt;
            text-transform: uppercase;
        }

        .kop-text p {
            margin: 0;
            font-size: 10pt;
            font-style: italic;
        }

        /* Judul & Isi (Akan diisi oleh file anak) */
        .judul-surat {
            text-align: center;
            margin-bottom: 20px;
        }

        .judul-surat h4 {
            text-decoration: underline;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .isi-surat {
            text-align: justify;
        }

        .data-table {
            margin: 15px 0 15px 40px;
        }

        .data-table td {
            padding: 2px 5px;
            vertical-align: top;
        }

        /* Tanda Tangan */
        .ttd-wrapper {
            margin-top: 30px;
            width: 100%;
        }

        .ttd-box {
            float: right;
            width: 250px;
            text-align: center;
            line-height: 0.5;
        }

        .space {
            height: 70px;
        }
    </style>
</head>

<body>
    <div class="container">
        {{-- KOP SURAT TETAP --}}
        <table class="kop-tabel">
            <tr>
                <td width="15%"><img src="{{ public_path('img/mainLogo.png') }}" class="logo-img"></td>
                <td width="85%" class="kop-text">
                    <h3>PEMERINTAH KABUPATEN LAMPUNG SELATAN</h3>
                    <h3>KECAMATAN NATAR</h3>
                    <h2>KANTOR KEPALA DESA KRAWANG SARI</h2>
                    <p>Alamat: Jl. Raya Krawang Sari No. 01 Kode Pos 35357</p>
                </td>
                <td width="15%"></td>
            </tr>
        </table>

        {{-- BAGIAN DINAMIS (Diisi oleh surat beasiswa/SKTM/dll) --}}
        @yield('content')

        {{-- TANDA TANGAN TETAP --}}
        <div class="ttd-wrapper">
            <div class="ttd-box">
                <p>Krawang Sari, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                <p>Kepala Desa Krawang Sari</p>
                <div class="space"></div>
                <p style="text-decoration: underline;"><strong>NIKMATUS SOLEKAH</strong></p>
                <p>NIP. .........................</p>
            </div>
        </div>
    </div>
</body>

</html>
