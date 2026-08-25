<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratPengantarKtpDetail extends Model
{
    protected $table = 'surat_pengantar_ktp_detail';

    protected $primaryKey = 'pengajuan_id';

    public $incrementing = false;

    protected $fillable = ['pengajuan_id', 'jenis_pengurusan', 'alasan_pengurusan'];

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanSurat::class, 'pengajuan_id');
    }
}
