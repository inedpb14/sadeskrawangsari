@extends('admin.surat.pdf-layout')

@section('title', 'Surat Keterangan Perubahan Data')

@section('content')
    <div class="judul-surat">
        <h4 style="text-decoration: underline; margin-bottom: 5px;">SURAT KETERANGAN PERUBAHAN DATA</h4>
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
            <tr>
                <td>Data Lama</td>
                <td>: {{ $surat->perubahanDataDetail->data_lama ?? '-' }}</td>
            </tr>
            <tr>
                <td>Data Baru</td>
                <td>: {{ $surat->perubahanDataDetail->data_baru ?? '-' }}</td>
            </tr>
            <tr>
                <td>Alasan Perubahan</td>
                <td>: {{ $surat->perubahanDataDetail->alasan_perubahan ?? '-' }}</td>
            </tr>
        </table>

        <p>Demikian surat keterangan perubahan data ini dibuat dengan sebenarnya agar dapat dipergunakan sebagaimana
            mestinya.</p>
    </div>

    <div style="clear: both;"></div>
@endsection
