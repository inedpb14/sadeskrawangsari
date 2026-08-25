@extends('admin.surat.pdf-layout')

@section('title', 'Surat Rekomendasi Beasiswa')

@section('content')
<div class="judul-surat">
    <h4>SURAT REKOMENDASI BEASISWA</h4>
    <span>Nomor: 420 / {{ str_pad($surat->id, 3, '0', STR_PAD_LEFT) }} / DS-KS / {{ date('Y') }}</span>
</div>

<div class="isi-surat">
    <p>Yang bertanda tangan di bawah ini Kepala Desa Krawang Sari, Kecamatan Natar, Kabupaten Lampung Selatan, menerangkan bahwa:</p>

    <table class="data-table">
        <tr>
            <td width="160">Nama Lengkap</td>
            <td>: <strong>{{ $surat->warga->nama_lengkap }}</strong></td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>: {{ $surat->warga_nik }}</td>
        </tr>
        <tr>
            <td>Pekerjaan/Status</td>
            <td>: Pelajar/Mahasiswa</td>
        </tr>
        {{-- Tambahkan data lain sesuai kebutuhan --}}
    </table>

    <p>Nama tersebut di atas adalah benar warga Desa Krawang Sari yang memiliki berkelakuan baik yang bermaksud mengajukan beasiswa kepada <strong>{{ $surat->beasiswaDetail->nama_institusi ?? 'Institusi Beasiswa' }}</strong>.</p>

    <p>Demikian surat rekomendasi ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</p>
</div>
@endsection