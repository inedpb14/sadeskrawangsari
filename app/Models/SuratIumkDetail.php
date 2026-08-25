<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratIumkDetail extends Model
{
    protected $table = 'surat_iumk_detail';

    protected $primaryKey = 'pengajuan_id';

    public $incrementing = false;

    protected $fillable = ['pengajuan_id', 'nama_usaha', 'jenis_usaha', 'lokasi_usaha', 'modal_usaha'];

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanSurat::class, 'pengajuan_id');
    }
}
