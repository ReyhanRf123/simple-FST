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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id(); // bigint [cite: 972, 973]
            $table->foreignId('user_id')->constrained('users'); // FK penerima [cite: 981, 982]
            $table->foreignId('complaint_id')->constrained('complaints'); // FK [cite: 985, 986]
            $table->text('message'); // text [cite: 990, 991]
            $table->boolean('is_read')->default(false); // boolean [cite: 994, 995]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
