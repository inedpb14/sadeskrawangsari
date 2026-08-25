@extends('admin.surat.pdf-layout')

@section('title', 'Surat Keterangan Penghasilan')

@section('content')
    <div class="judul-surat">
        <h4 style="text-decoration: underline; margin-bottom: 5px;">SURAT KETERANGAN PENGHASILAN</h4>
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
            {{-- Tambahkan TTL atau Alamat di sini jika diperlukan --}}

            <tr>
                <td colspan="2"><br><strong>Menerangkan rincian pekerjaan dan penghasilan sebagai berikut:</strong></td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>: {{ $surat->penghasilanDetail->pekerjaan_sebenarnya ?? '-' }}</td>
            </tr>
            <tr>
                <td>Nama Perusahaan / Instansi</td>
                <td>: {{ $surat->penghasilanDetail->tempat_kerja ?? '-' }}</td>
            </tr>
            <tr>
                <td>Rata-rata Penghasilan</td>
                <td>: <strong>Rp
                        {{ number_format($surat->penghasilanDetail->penghasilan_per_bulan ?? 0, 0, ',', '.') }}</strong> /
                    bulan</td>
            </tr>
        </table>

        <p>Berdasarkan keterangan yang bersangkutan, surat ini dibuat untuk keperluan:
            <strong>{{ $surat->penghasilanDetail->tujuan_surat ?? '-' }}</strong>.</p>

        <p>Demikian surat keterangan penghasilan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.
            Segala akibat yang timbul di kemudian hari menjadi tanggung jawab mutlak pemohon.</p>
    </div>

    <div style="clear: both;"></div>
@endsection
