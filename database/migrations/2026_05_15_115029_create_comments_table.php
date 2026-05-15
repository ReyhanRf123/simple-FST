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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel complaints (jika laporan dihapus, komentar ikut terhapus)
            $table->foreignId('complaint_id')->constrained()->cascadeOnDelete();
            // Relasi ke tabel users (siapa yang mengirim komentar)
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            // Isi komentar
            $table->text('body');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
