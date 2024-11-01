<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user'); // Kolom ID
            $table->string('name'); // Nama pengguna
            $table->string('email')->unique(); // Email pengguna
            $table->string('password'); // Password pengguna
            $table->string('role')->default('user'); // Kolom untuk role pengguna
            $table->string('foto_user')->nullable(); // Kolom untuk foto pengguna
            $table->timestamps(); // Kolom created_at dan updated_at
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
