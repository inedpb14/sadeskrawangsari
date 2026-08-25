<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengaturan_desa', function (Blueprint $table) {
            $table->id();
            $table->string('nama_desa', 150)->default('Desa Krawang Sari');
            $table->text('alamat')->nullable();
            $table->string('telepon', 30)->nullable();
            $table->string('email', 100)->nullable();
            $table->longText('visi_misi')->nullable();
            $table->longText('sejarah')->nullable();
            $table->text('sambutan_kades')->nullable();
            $table->string('nama_kades', 100)->nullable();
            $table->string('foto_kades', 255)->nullable();
            $table->string('hero_image', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturan_desa');
    }
};
