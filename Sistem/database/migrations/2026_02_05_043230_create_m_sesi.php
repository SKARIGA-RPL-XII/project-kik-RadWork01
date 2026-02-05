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
        Schema::create('m_sesi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('m_jadwal_id');
            $table->time('tanggal');
            $table->string('qr_token', 100)->unique();
            $table->enum('status', ['belum', 'aktif', 'selesai']);


            $table->timestamps();
            $table->softDeletes();

            $table->index('m_jadwal_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_sesi');
    }
};
