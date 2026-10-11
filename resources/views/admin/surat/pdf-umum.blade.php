@extends('admin.surat.pdf-layout')

@section('title', 'Surat Keterangan Desa')

@section('content')
    <div class="judul-surat">
        <h4 style="text-decoration: underline; margin-bottom: 5px;">{{ $surat->jenisSurat->nama_surat ?? 'SURAT KETERANGAN DESA' }}</h4>
        <span>Nomor: {{ $surat->nomor_surat }}</span>
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
        </table>

        <p>Nama tersebut di atas benar warga Desa Krawang Sari. Surat keterangan ini dibuat untuk dipergunakan
            sebagaimana mestinya.</p>

        <p>Demikian surat keterangan ini dibuat dengan sebenarnya.</p>
    </div>

    <div style="clear: both;"></div>
@endsection
