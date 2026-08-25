<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratBelumMenikahDetail extends Model
{
    protected $table = 'surat_belummenikah_detail';

    protected $primaryKey = 'pengajuan_id';

    public $incrementing = false;

    protected $fillable = ['pengajuan_id', 'tujuan_permohonan', 'nama_pasangan_ideal'];

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanSurat::class, 'pengajuan_id');
    }
}
