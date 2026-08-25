@extends('admin.surat.pdf-layout')

@section('title', 'Surat Keterangan Tidak Mampu')

@section('content')
    <div class="judul-surat">
        <h4 style="text-decoration: underline; margin-bottom: 5px;">SURAT KETERANGAN TIDAK MAMPU</h4>
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
            {{-- Anda bisa menambahkan Tempat/Tanggal Lahir atau Alamat dari relasi $surat->warga jika ada --}}

            <tr>
                <td colspan="2"><br><strong>Keterangan Ekonomi Keluarga:</strong></td>
            </tr>
            <tr>
                <td>Total Penghasilan Kepala Keluarga</td>
                <td>: Rp {{ number_format($surat->sktmDetail->total_penghasilan_keluarga ?? 0, 0, ',', '.') }} / bulan</td>
            </tr>
            <tr>
                <td>Jumlah Tanggungan</td>
                <td>: {{ $surat->sktmDetail->jumlah_tanggungan ?? 0 }} Orang</td>
            </tr>
            <tr>
                <td>Keterangan Aset/Harta</td>
                <td>: {{ $surat->sktmDetail->keterangan_aset ?? '-' }}</td>
            </tr>
        </table>

        <p>Berdasarkan pengamatan perangkat desa dan keterangan yang bersangkutan, nama tersebut di atas benar-benar warga
            Desa Krawang Sari yang tergolong ke dalam keluarga berpenghasilan rendah / <strong>Keluarga Kurang Mampu
                (Pra-Sejahtera)</strong>.</p>

        <p>Surat keterangan ini dibuat dan diberikan kepada yang bersangkutan untuk keperluan:
            <strong>{{ $surat->sktmDetail->tujuan_sktm ?? 'Persyaratan Administrasi' }}</strong>.</p>

        <p>Demikian surat keterangan tidak mampu ini dibuat dengan sebenarnya agar dapat dipergunakan sebagaimana mestinya.
        </p>
    </div>

    <div style="clear: both;"></div>
@endsection
