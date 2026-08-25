<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => env('ADMIN_SEEDER_EMAIL', 'admin@desakrawangsari.com')],
            [
                'name' => env('ADMIN_SEEDER_NAME', 'Admin Desa'),
                'role' => 'admin',
                'is_active' => 1,
                'password' => env('ADMIN_SEEDER_PASSWORD', 'admin12345'),
            ]
        );

        $this->command->info("Akun admin siap: {$admin->email} / ".env('ADMIN_SEEDER_PASSWORD', 'admin12345'));
    }
}
