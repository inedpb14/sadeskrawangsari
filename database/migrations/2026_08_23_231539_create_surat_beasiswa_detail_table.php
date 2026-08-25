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
        Schema::create('surat_beasiswa_detail', function (Blueprint $table) {
            $table->foreignId('pengajuan_id')->constrained('pengajuan_surat')->onDelete('cascade')->onUpdate('cascade');
            $table->string('nama_institusi', 255);
            $table->enum('tingkat_pendidikan', ['SD', 'SMP', 'SMA', 'Perguruan Tinggi', 'Lainnya']);
            $table->string('nama_penerima_beasiswa', 150);
            $table->timestamps();

            $table->primary('pengajuan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_beasiswa_detail');
    }
};
