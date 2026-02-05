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
        Schema::create('m_user', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('m_role_id');
            $table->string('email', 100)->unique();
            $table->string('password', 255);
            $table->boolean('status');
            $table->timestamps();
            $table->softDeletes();

            $table->index('m_role_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_user');
    }
};
