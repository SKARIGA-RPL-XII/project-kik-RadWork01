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
        Schema::create('m_guru', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('m_user_id');
            $table->string('nip', 20)->unique();
            $table->string('nama', 100);
            $table->enum('jenis_kelamin', ['m', 'f']);
            $table->string('telepon', 15);
            $table->string('photo_url', 255)->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('m_user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_guru');
    }
};
