@extends('admin.surat.pdf-layout')

@section('title', 'Surat Keterangan Izin Keramaian')

@section('content')
    <div class="judul-surat">
        <h4 style="text-decoration: underline; margin-bottom: 5px;">SURAT PENGANTAR IZIN KERAMAIAN</h4>
        <span>Nomor: {{ $surat->no_surat ?? $surat->nomor_surat }}</span>
    </div>

    <div class="isi-surat">
        <p>Yang bertanda tangan di bawah ini Kepala Desa Krawang Sari, Kecamatan Natar, Kabupaten Lampung Selatan,
            menerangkan dengan sebenarnya bahwa:</p>

        <table class="data-table" style="width: 100%; margin-bottom: 15px;">
            <tr>
                <td width="180">Nama Penanggung Jawab</td>
                <td>: <strong>{{ $surat->izinKeramaianDetail->penanggung_jawab ?? $surat->warga->nama_lengkap }}</strong>
                </td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>: {{ $surat->warga_nik }}</td>
            </tr>

            <tr>
                <td colspan="2"><br><strong>Bermaksud mengadakan kegiatan keramaian berupa:</strong></td>
            </tr>
            <tr>
                <td>Nama Kegiatan</td>
                <td>: <strong>{{ $surat->izinKeramaianDetail->nama_kegiatan ?? '-' }}</strong></td>
            </tr>
            <tr>
                <td>Tanggal Pelaksanaan</td>
                <td>: {{ \Carbon\Carbon::parse($surat->izinKeramaianDetail->tgl_mulai)->translatedFormat('d F Y') }} s/d
                    {{ \Carbon\Carbon::parse($surat->izinKeramaianDetail->tgl_selesai)->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <td style="vertical-align: top;">Lokasi Kegiatan</td>
                <td style="vertical-align: top;">: {{ $surat->izinKeramaianDetail->lokasi_kegiatan ?? '-' }}</td>
            </tr>
        </table>

        <p>Pada prinsipnya, Pemerintah Desa Krawang Sari tidak keberatan atas diselenggarakannya kegiatan tersebut, dengan
            ketentuan penanggung jawab wajib menjaga keamanan, ketertiban, dan mematuhi peraturan yang berlaku.</p>

        <p>Surat ini merupakan pengantar untuk mengurus <strong>Surat Izin Keramaian</strong> pada pihak berwajib
            (Kepolisian setempat). Demikian surat pengantar ini dibuat agar dapat dipergunakan sebagaimana mestinya.</p>
    </div>

    <div style="clear: both;"></div>
@endsection
