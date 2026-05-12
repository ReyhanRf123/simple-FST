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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('user_id')->constrained('users'); 
            $table->foreignId('facility_id')->constrained('facilities'); 
            $table->string('location'); 
            $table->text('description'); 
            $table->enum('severity_level', ['ringan', 'sedang', 'kritis']); 
            $table->integer('priority_score'); 
            $table->enum('status', ['menunggu', 'diproses', 'selesai', 'ditolak'])->default('menunggu'); 
            
            // Foto dari Pelapor (Bukti Kerusakan)
            $table->string('image')->nullable(); 
            
            // Foto dari Admin (Bukti Perbaikan) 
            $table->string('resolved_image')->nullable(); 

            $table->text('catatan_teknisi')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
