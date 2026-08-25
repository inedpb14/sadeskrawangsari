<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratKematianDetail extends Model
{
    protected $table = 'surat_kematian_detail';

    protected $primaryKey = 'pengajuan_id';

    public $incrementing = false;

    protected $fillable = [
        'pengajuan_id',
        'nik_yang_meninggal',
        'nama_yang_meninggal',
        'tanggal_kematian',
        'tempat_kematian',
        'penyebab_kematian',
        'nik_pelapor',
    ];

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanSurat::class, 'pengajuan_id');
    }
}
