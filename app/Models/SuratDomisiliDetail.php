<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratDomisiliDetail extends Model
{
    protected $table = 'surat_domisili_detail';

    protected $primaryKey = 'pengajuan_id';

    public $incrementing = false;

    protected $fillable = ['pengajuan_id', 'tujuan_pembuatan'];

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanSurat::class, 'pengajuan_id');
    }
}
