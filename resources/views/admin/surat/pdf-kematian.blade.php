@extends('admin.surat.pdf-layout')

@section('title', 'Surat Keterangan Kematian')

@section('content')
    <div class="judul-surat">
        <h4 style="text-decoration: underline; margin-bottom: 5px;">SURAT KETERANGAN KEMATIAN</h4>
        <span>Nomor: {{ $surat->nomor_surat }}</span>
    </div>

    <div class="isi-surat">
        <p>Yang bertanda tangan di bawah ini Kepala Desa Krawang Sari, Kecamatan Natar, Kabupaten Lampung Selatan,
            menerangkan dengan sesungguhnya bahwa:</p>

        <table class="data-table" style="width: 100%; margin-bottom: 15px;">
            <tr>
                <td width="180">Nama yang Meninggal</td>
                <td>: <strong>{{ $surat->kematianDetail->nama_yang_meninggal ?? '-' }}</strong></td>
            </tr>
            <tr>
                <td>NIK yang Meninggal</td>
                <td>: {{ $surat->kematianDetail->nik_yang_meninggal ?? '-' }}</td>
            </tr>
            <tr>
                <td>Tanggal Kematian</td>
                <td>: {{ $surat->kematianDetail->tanggal_kematian ?? '-' }}</td>
            </tr>
            <tr>
                <td>Tempat Kematian</td>
                <td>: {{ $surat->kematianDetail->tempat_kematian ?? '-' }}</td>
            </tr>
            <tr>
                <td>Penyebab Kematian</td>
                <td>: {{ $surat->kematianDetail->penyebab_kematian ?? '-' }}</td>
            </tr>
            <tr>
                <td>NIK Pelapor</td>
                <td>: {{ $surat->kematianDetail->nik_pelapor ?? '-' }}</td>
            </tr>
        </table>

        <p>Demikian surat keterangan kematian ini dibuat dengan sebenarnya agar dapat dipergunakan sebagaimana mestinya.
        </p>
    </div>

    <div style="clear: both;"></div>
@endsection
