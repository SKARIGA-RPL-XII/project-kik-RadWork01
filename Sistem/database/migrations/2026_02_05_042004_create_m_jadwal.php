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
        Schema::create('m_jadwal', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('m_kelas_id');
            $table->uuid('m_mapel_guru_id');
            $table->tinyInteger('hari');
            $table->time('jam_mulai');
            $table->time('jam_selesai');

            $table->timestamps();
            $table->softDeletes();

            $table->index('m_kelas_id');
            $table->index('m_mapel_guru_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_jadwal');
    }
};
