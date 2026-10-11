<?php

namespace App\Services;

use App\Models\PengajuanSurat;
use App\Models\Warga;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfSuratService
{
    protected $templateMap = [
        'SKTM' => 'admin.surat.pdf-sktm',
        'BEAS' => 'admin.surat.pdf-rekomendasi-beasiswa',
        'IUMK' => 'admin.surat.pdf-iumk',
        'DOMI' => 'admin.surat.pdf-domisili',
        'PHSL' => 'admin.surat.pdf-penghasilan',
        'BLMK' => 'admin.surat.pdf-belummenikah',
        'HILG' => 'admin.surat.pdf-kehilangan',
        'KMAT' => 'admin.surat.pdf-kematian',
        'PNTR' => 'admin.surat.pdf-pengantar',
        'JAMK' => 'admin.surat.pdf-jamkes',
        'IZRM' => 'admin.surat.pdf-keramaian',
        'PNDH' => 'admin.surat.pdf-pindah',
        'UBDT' => 'admin.surat.pdf-perubahandata',
    ];

    protected $relations = [
        'warga',
        'jenisSurat',
        'penghasilanDetail',
        'sktmDetail',
        'beasiswaDetail',
        'iumkDetail',
        'domisiliDetail',
        'belumMenikahDetail',
        'izinKeramaianDetail',
        'kehilanganDokDetail',
        'pengantarDetail',
        'pengantarKtpDetail',
        'jaminanKesehatanDetail',
        'kematianDetail',
        'pindahDetail',
        'perubahanDataDetail',
    ];

    public function generate(PengajuanSurat $surat, ?string $filename = null)
    {
        $surat->load($this->relations);

        $kodeSurat = $surat->jenisSurat?->kode_surat ?? 'UMUM';
        $view = $this->templateMap[$kodeSurat] ?? 'admin.surat.pdf-umum';

        $pdf = Pdf::loadView($view, compact('surat'));
        $pdf->setPaper('letter', 'portrait');

        $name = $filename ?? 'Surat_'.$surat->jenisSurat->nama_surat.'_'.$surat->warga->nama_lengkap.'.pdf';

        return $pdf->stream($name);
    }

    public function canPrint(Warga $warga, PengajuanSurat $surat): bool
    {
        return $surat->warga_nik === $warga->nik && $surat->status === 'Disetujui';
    }
}
