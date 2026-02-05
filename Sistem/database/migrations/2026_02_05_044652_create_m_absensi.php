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
        Schema::create('m_absensi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('m_sesi_id');
            $table->uuid('m_siswa_id');
            $table->enum('status_hadir', ['hadir', 'telat', 'izin', 'alfa']);
            $table->enum('input_type', ['qr', 'manual']);
            $table->string('alasan')->nullable();
            $table->decimal('latitude', 10,7);
            $table->decimal('longitude', 10,7);
            $table->decimal('distance_meter', 6,2);

            $table->timestamps();
            $table->softDeletes();

            $table->index('m_sesi_id');
            $table->index('m_siswa_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_absensi');
    }
};
