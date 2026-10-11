@extends('admin.surat.pdf-layout')

@section('title', 'Surat Pengantar Pindah Domisili')

@section('content')
    <div class="judul-surat">
        <h4 style="text-decoration: underline; margin-bottom: 5px;">SURAT PENGANTAR PINDAH DOMISILI</h4>
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
                <td>Alamat Tujuan</td>
                <td>: {{ $surat->pindahDetail->alamat_tujuan_lengkap ?? '-' }}</td>
            </tr>
            <tr>
                <td>Alasan Pindah</td>
                <td>: {{ $surat->pindahDetail->alasan_pindah ?? '-' }}</td>
            </tr>
            <tr>
                <td>Rencana Pindah</td>
                <td>: {{ $surat->pindahDetail->tgl_rencana_pindah ?? '-' }}</td>
            </tr>
            <tr>
                <td>Jumlah Ikut Pindah</td>
                <td>: {{ $surat->pindahDetail->jumlah_ikut_pindah ?? 0 }} Orang</td>
            </tr>
        </table>

        <p>Demikian surat pengantar pindah domisili ini dibuat dengan sebenarnya agar dapat dipergunakan sebagaimana
            mestinya.</p>
    </div>

    <div style="clear: both;"></div>
@endsection
