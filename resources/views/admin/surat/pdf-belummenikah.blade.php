@extends('admin.surat.pdf-layout')

@php
    // Cek apakah variabel nama_pasangan_ideal diisi oleh warga
    $isPengantarNikah = !empty($surat->belumMenikahDetail->nama_pasangan_ideal);

    // Tentukan Judul Dinamis
    $judulSurat = $isPengantarNikah ? 'SURAT PENGANTAR NIKAH' : 'SURAT KETERANGAN BELUM MENIKAH';
@endphp

@section('title', $judulSurat)

@section('content')
    <div class="judul-surat">
        <h4 style="text-decoration: underline; margin-bottom: 5px;">{{ $judulSurat }}</h4>
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
            <tr>
                <td>Status Perkawinan</td>
                <td>: Belum Kawin</td>
            </tr>
            {{-- Sangat disarankan untuk menambahkan Tempat Tanggal Lahir, Jenis Kelamin, dan Agama dari tabel warga jika ada --}}
        </table>

        @if ($isPengantarNikah)
            {{-- PARAGRAF JIKA INI PENGANTAR NIKAH --}}
            <p>Berdasarkan catatan yang ada pada register desa kami, nama tersebut di atas benar-benar berstatus
                <strong>Belum Pernah Menikah</strong> (Jejaka / Perawan). Surat ini diterbitkan sebagai pengantar bahwa yang
                bersangkutan bermaksud untuk melangsungkan pernikahan dengan calon pasangannya yang bernama:</p>

            <table class="data-table" style="width: 100%; margin: 10px 0 15px 30px;">
                <tr>
                    <td width="150">Nama Calon Pasangan</td>
                    <td>: <strong>{{ $surat->belumMenikahDetail->nama_pasangan_ideal }}</strong></td>
                </tr>
            </table>
        @else
            {{-- PARAGRAF JIKA INI HANYA KET. BELUM MENIKAH BIASA --}}
            <p>Berdasarkan sepengetahuan kami dan catatan yang ada pada register desa, nama tersebut di atas adalah benar
                warga Desa Krawang Sari dan hingga saat surat ini dikeluarkan yang bersangkutan benar-benar berstatus
                <strong>Belum Pernah Menikah</strong>.</p>
        @endif

        <p>Surat keterangan ini dibuat untuk dipergunakan sebagai:
            <strong>{{ $surat->belumMenikahDetail->tujuan_permohonan ?? '-' }}</strong>.</p>

        <p>Demikian surat keterangan ini kami buat dengan sebenarnya agar dapat dipergunakan sebagaimana mestinya oleh pihak
            yang berkepentingan.</p>
    </div>

    <div style="clear: both;"></div>
@endsection
