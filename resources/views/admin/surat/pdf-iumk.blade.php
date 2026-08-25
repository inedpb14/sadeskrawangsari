@extends('admin.surat.pdf-layout')

@section('title', 'Surat Keterangan Izin Usaha')

@section('content')
    <div class="judul-surat">
        <h4 style="text-decoration: underline; margin-bottom: 5px;">SURAT KETERANGAN USAHA / IUMK</h4>
        {{-- Sesuaikan nama variabel dengan kolom database Anda, no_surat atau nomor_surat --}}
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
            {{-- Anda bisa menambahkan baris Alamat, TTL, atau Agama sesuai profil warga --}}

            <tr>
                <td colspan="2"><br><strong>Keterangan Usaha:</strong></td>
            </tr>
            <tr>
                <td>Nama Usaha</td>
                <td>: <strong>{{ $surat->iumkDetail->nama_usaha ?? '-' }}</strong></td>
            </tr>
            <tr>
                <td>Jenis/Bidang Usaha</td>
                <td>: {{ $surat->iumkDetail->jenis_usaha ?? '-' }}</td>
            </tr>
            <tr>
                <td>Modal Usaha</td>
                <td>: Rp {{ number_format($surat->iumkDetail->modal_usaha ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td style="vertical-align: top;">Lokasi Usaha</td>
                <td style="vertical-align: top;">: {{ $surat->iumkDetail->lokasi_usaha ?? '-' }}</td>
            </tr>
        </table>

        <p>Berdasarkan pengamatan perangkat desa dan keterangan yang bersangkutan, nama tersebut di atas adalah benar-benar
            warga Desa Krawang Sari dan saat ini benar-benar memiliki / menjalankan usaha sebagaimana yang tercantum pada
            rincian di atas.</p>

        <p>Surat keterangan ini dibuat sebagai pengantar / rekomendasi bagi yang bersangkutan untuk keperluan <strong>Izin
                Usaha Mikro Kecil (IUMK)</strong>, Administrasi Perbankan, atau keperluan lain yang semestinya.</p>

        <p>Demikian surat keterangan ini kami buat agar dapat dipergunakan sebagaimana mestinya.</p>
    </div>

    <div style="clear: both;"></div>
@endsection
