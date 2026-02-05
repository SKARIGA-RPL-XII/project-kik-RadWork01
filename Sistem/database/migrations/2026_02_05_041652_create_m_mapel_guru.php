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
        Schema::create('m_mapel_guru', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('m_guru_id');
            $table->uuid('m_mapel_id');

            $table->timestamps();
            $table->softDeletes();

            $table->index('m_guru_id');
            $table->index('m_mapel_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_mapel_guru');
    }
};
