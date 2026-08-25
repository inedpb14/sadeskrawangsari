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
        Schema::create('aktivitas_logs', function (Blueprint $table) {
            $table->id();
            $table->string('user_name')->nullable(); // Nama admin/user yang melakukan aksi
            $table->string('aksi'); // Contoh: "Menyetujui Surat SKTM"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aktivitas_logs');
    }
};
