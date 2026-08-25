<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    // Menentukan nama tabel
    protected $table = 'settings';

    // Kolom yang boleh diisi
    protected $fillable = [
        'key',
        'value',
        'type',
    ];
}
