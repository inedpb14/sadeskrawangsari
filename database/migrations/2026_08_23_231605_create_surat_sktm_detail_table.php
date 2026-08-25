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
        Schema::create('surat_sktm_detail', function (Blueprint $table) {
            $table->foreignId('pengajuan_id')->constrained('pengajuan_surat')->onDelete('cascade')->onUpdate('cascade');
            $table->string('tujuan_sktm', 255);
            $table->integer('jumlah_tanggungan');
            $table->string('keterangan_aset', 255);
            $table->decimal('total_penghasilan_keluarga', 15, 2);
            $table->timestamps();

            $table->primary('pengajuan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_sktm_detail');
    }
};
