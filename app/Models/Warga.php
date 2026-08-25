<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Warga extends Authenticatable
{
    use Notifiable;

    protected $table = 'warga';

    // Konfigurasi Primary Key Custom (NIK)
    protected $primaryKey = 'nik';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'nik',
        'user_id',
        'no_kk',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat_jalan',
        'rt_rw',
        'kel_desa',
        'kecamatan',
        'agama',
        'status_perkawinan',
        'pekerjaan',
        'kewarganegaraan',
        'no_hp',
        'foto',
        'is_active',
    ];

    public function keluarga()
    {
        return $this->belongsTo(Keluarga::class, 'id_keluarga', 'id');
    }

    public function getAuthIdentifierName()
    {
        return 'nik';
    }

    // Relasi ke tabel users
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
