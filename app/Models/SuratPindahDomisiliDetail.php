<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratPindahDomisiliDetail extends Model
{
    protected $table = 'surat_pindah_domisili_detail';

    protected $primaryKey = 'pengajuan_id';

    public $incrementing = false;

    protected $fillable = [
        'pengajuan_id',
        'alamat_tujuan_lengkap',
        'alasan_pindah',
        'tgl_rencana_pindah',
        'jumlah_ikut_pindah',
    ];

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanSurat::class, 'pengajuan_id');
    }
}
