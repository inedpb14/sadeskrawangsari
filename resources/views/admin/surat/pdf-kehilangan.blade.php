@extends('admin.surat.pdf-layout')

@section('title', 'Surat Keterangan Kehilangan')

@section('content')
    <div class="judul-surat">
        <h4 style="text-decoration: underline; margin-bottom: 5px;">SURAT KETERANGAN KEHILANGAN</h4>
        <span>Nomor: {{ $surat->no_surat ?? $surat->nomor_surat }}</span>
    </div>

    <div class="isi-surat">
        <p>Yang bertanda tangan di bawah ini Kepala Desa Krawang Sari, Kecamatan Natar, Kabupaten Lampung Selatan,
            menerangkan dengan sesungguhnya bahwa:</p>

        <table class="data-table" style="width: 100%; margin-bottom: 15px;">
            <tr>
                <td width="180">Nama Lengkap</td>
                <td>: <strong>{{ $surat->warga->nama_lengkap }}</strong></td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>: {{ $surat->warga_nik }}</td>
            </tr>
            {{-- Anda bisa menambahkan Alamat dari relasi $surat->warga jika ada --}}
        </table>

        <p>Berdasarkan laporan dan keterangan dari yang bersangkutan, bahwa nama tersebut di atas benar-benar warga Desa
            Krawang Sari yang melaporkan telah kehilangan barang/dokumen berharga berupa:</p>

        <table class="data-table" style="width: 100%; margin: 10px 0 15px 30px;">
            <tr>
                <td width="150">Jenis Barang/Dokumen</td>
                <td>: <strong>{{ $surat->kehilanganDokDetail->jenis_dokumen_hilang ?? '-' }}</strong></td>
            </tr>
            <tr>
                <td>Lokasi Kehilangan</td>
                <td>: {{ $surat->kehilanganDokDetail->lokasi_hilang ?? '-' }}</td>
            </tr>
            <tr>
                <td style="vertical-align: top;">Keterangan</td>
                <td style="vertical-align: top;">: {{ $surat->kehilanganDokDetail->keterangan_hilang ?? '-' }}</td>
            </tr>
        </table>

        <p>Surat Keterangan Pengantar ini dibuat untuk dipergunakan sebagai syarat pengurusan <strong>Surat Keterangan Tanda
                Lapor Kehilangan (SKTLK)</strong> dari instansi Kepolisian, maupun pengurusan dokumen pengganti pada
            instansi terkait.</p>

        <p>Demikian surat keterangan ini kami buat dengan sebenarnya agar dapat dipergunakan sebagaimana mestinya.</p>
    </div>

    <div style="clear: both;"></div>
@endsection
