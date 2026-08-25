<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    protected $table = 'pengaduan';

    protected $fillable = [
        'warga_nik',
        'kategori',
        'judul',
        'isi_pengaduan',
        'lampiran_path',
        'status',
        'tanggapan_admin',
        'admin_id',
    ];

    public function warga()
    {
        return $this->belongsTo(Warga::class, 'warga_nik', 'nik');
    }
}
