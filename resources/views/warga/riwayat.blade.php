@extends('layouts.app-warga')

@section('title', 'Riwayat Pengajuan')

@section('content')
    <div class="welcome-card-2">
        <h1>Riwayat Pengajuan Surat</h1>
        <p>Pantau status surat yang telah Anda ajukan kepada pemerintah desa.</p>
    </div>

    <div class="container-keluarga">

        @if (session('success'))
            <div class="alert-success"
                style="background:#d4edda; color:#155724; padding:15px; border-radius:10px; margin-bottom:20px;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <div class="table-card"
            style="background:white; padding:25px; border-radius:20px; box-shadow:0 10px 30px rgba(0,0,0,0.05);">
            <h3 style="margin-top:0;"><i class="fas fa-history"></i>
                Daftar Riwayat Pengajuan</h3>

            <div style="overflow-x: auto;">
                <table style="width:100%; border-collapse: collapse; min-width: 900px;">
                    <thead>
                        <tr style="text-align:left; border-bottom: 2px solid #eee;">
                            <th style="padding:12px; width: 5%;">No</th>
                            <th style="padding:12px;">Tgl Pengajuan</th>
                            <th style="padding:12px;">Nama Dalam Surat</th>
                            <th style="padding:12px;">Jenis Surat</th>
                            <th style="padding:12px;">Metode Ambil</th>
                            <th style="padding:12px; text-align:center;">Status</th>
                            <th style="padding:12px; text-align:center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayat as $index => $item)
                            <tr style="border-bottom: 1px solid #eee;">
                                <td style="padding:12px;">{{ $index + 1 }}</td>
                                <td style="padding:12px;">
                                    {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') }}</td>

                                <td style="padding:12px;">
                                    <strong>{{ $item->warga->nama_lengkap ?? 'Data tidak ditemukan' }}</strong>
                                    @if ($item->warga_nik == Auth::guard('warga')->user()->nik)
                                        <br><span style="font-size: 11px; color: var(--color-2);">(Saya)</span>
                                    @else
                                        <br><span style="font-size: 11px; color: #888;">(Anggota Keluarga)</span>
                                    @endif
                                </td>

                                <td style="padding:12px;">{{ $item->jenisSurat->nama_surat ?? 'Data tidak ditemukan' }}</td>
                                <td style="padding:12px;">{{ ucfirst($item->metode_ambil) }}</td>
                                <td style="padding:12px; text-align:center;">
                                    @php
                                        $bg = '#6c757d'; // default secondary
                                        $color = '#fff';

                                        if ($item->status == 'Diajukan') {
                                            $bg = '#ffc107'; // warning
                                            $color = '#000';
                                        } elseif ($item->status == 'Diproses') {
                                            $bg = '#17a2b8'; // info
                                        } elseif ($item->status == 'Disetujui') {
                                            $bg = '#28a745'; // success
                                        } elseif ($item->status == 'Ditolak') {
                                            $bg = '#dc3545'; // danger
                                        }
                                    @endphp
                                    <span
                                        style="background-color: {{ $bg }}; color: {{ $color }}; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; display: inline-block;">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td style="padding:12px; text-align:center;">
                                    @if ($item->status == 'Disetujui')
                                        @if ($item->metode_ambil == 'mandiri')
                                            <a href="{{ route('pengajuan.cetak', $item->id) }}" target="_blank"
                                                class="btn-print"
                                                style="background:var(--color-1); color:white; padding:8px 15px; border-radius:8px; text-decoration:none; font-size:14px; display:inline-block; font-weight:bold;">
                                                <i class="fas fa-print"></i> Cetak
                                            </a>
                                        @else
                                            <span
                                                style="color:var(--color-2); font-weight:bold; font-size:13px; display:inline-block; padding:8px 0;">
                                                <i class="fas fa-building"></i> Ambil di Kantor
                                            </span>
                                        @endif
                                    @else
                                        <button disabled
                                            style="background:#eee; color:#aaa; border:none; padding:8px 15px; border-radius:8px; font-size:14px; cursor:not-allowed; font-weight:bold;">
                                            <i class="fas fa-print"></i> Cetak
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="padding:30px; text-align:center; color:#888;">
                                    Belum ada riwayat pengajuan surat dalam keluarga Anda.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="pagination-wrapper" style="margin-top: 20px; text-align: center;">
        {{ $riwayat->links() }}
    </div>

    <style>
        .table-card h3 {
            color: var(--color-2);
            font-family: 'Domine', serif;
        }

        th {
            color: var(--color-1);
            font-size: 14px;
        }

        .btn-print:hover {
            opacity: 0.9;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection
