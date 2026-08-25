<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSurat extends Model
{
    use HasFactory;

    protected $table = 'jenis_surat';

    protected $fillable = [
        'kode_surat',
        'nama_surat',
        'kategori',
        'opsi_pengambilan',
    ];

    public $timestamps = false;

    /**
     * Relasi: Satu jenis surat memiliki banyak pengajuan
     */
    public function pengajuan()
    {
        return $this->hasMany(PengajuanSurat::class, 'jenis_surat_id', 'id');
    }
}
