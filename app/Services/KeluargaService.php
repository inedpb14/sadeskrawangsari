<?php

namespace App\Services;

use App\Models\Keluarga;

class KeluargaService
{
    public function create(array $data): Keluarga
    {
        return Keluarga::create([
            'no_kk' => $data['no_kk'],
            'nama_kepala_keluarga' => $data['nama_kepala_keluarga'],
        ]);
    }

    public function update(Keluarga $keluarga, array $data): Keluarga
    {
        $keluarga->update([
            'nama_kepala_keluarga' => $data['nama_kepala_keluarga'],
        ]);

        return $keluarga;
    }

    public function delete(Keluarga $keluarga): bool
    {
        return $keluarga->delete();
    }
}
