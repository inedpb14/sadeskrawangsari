@extends('admin.surat.pdf-layout')

@section('title', 'Surat Pengantar Kependudukan')

@section('content')
    <div class="judul-surat">
        <h4 style="text-decoration: underline; margin-bottom: 5px;">SURAT PENGANTAR KEPALA DESA</h4>
        <span>Nomor: {{ $surat->no_surat ?? $surat->nomor_surat }}</span>
    </div>

    <div class="isi-surat">
        <p>Yang bertanda tangan di bawah ini Kepala Desa Krawang Sari, Kecamatan Natar, Kabupaten Lampung Selatan,
            menerangkan dengan sebenarnya bahwa:</p>

        <table class="data-table" style="width: 100%; margin-bottom: 15px;">
            <tr>
                <td width="180">Nama Lengkap</td>
                <td>: <strong>{{ $surat->warga->nama_lengkap }}</strong></td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>: {{ $surat->warga_nik }}</td>
            </tr>
            {{-- Tambahkan TTL, Jenis Kelamin, dan Agama dari data warga jika ada --}}
        </table>

        <p>Berdasarkan catatan register desa kami, nama tersebut di atas adalah benar warga yang berdomisili di Desa Krawang
            Sari. Surat Pengantar ini diberikan kepada yang bersangkutan untuk mengurus keperluan administrasi kependudukan
            berupa:</p>

        <table class="data-table" style="width: 100%; margin: 10px 0 15px 30px;">
            <tr>
                <td width="150">Jenis Dokumen</td>
                <td>: <strong>{{ $surat->pengantarDetail->jenis_pengantar ?? '-' }}</strong></td>
            </tr>
            <tr>
                <td style="vertical-align: top;">Alasan / Keterangan</td>
                <td style="vertical-align: top;">: {{ $surat->pengantarDetail->keterangan ?? '-' }}</td>
            </tr>
        </table>

        <p>Demikian Surat Pengantar ini dibuat dengan sebenarnya, untuk dapat dipergunakan sebagai persyaratan administrasi
            pada instansi terkait (Kantor Kecamatan / Dinas Kependudukan dan Pencatatan Sipil).</p>
    </div>

    <div style="clear: both;"></div>
@endsection
