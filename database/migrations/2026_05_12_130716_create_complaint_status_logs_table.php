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
        Schema::create('complaint_status_logs', function (Blueprint $table) {
            $table->id(); // bigint [cite: 976, 977]
            $table->foreignId('complaint_id')->constrained('complaints'); // FK [cite: 978, 979]
            $table->foreignId('admin_id')->constrained('users'); // FK (Petugas yang memproses) [cite: 983, 984]
            $table->enum('old_status', ['menunggu', 'diproses', 'selesai', 'ditolak'])->nullable(); // [cite: 933, 989]
            $table->enum('new_status', ['menunggu', 'diproses', 'selesai', 'ditolak']); // [cite: 933, 993]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaint_status_logs');
    }
};
