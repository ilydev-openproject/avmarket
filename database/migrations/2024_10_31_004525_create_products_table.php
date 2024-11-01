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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Kolom ID
            $table->string('nama_product'); // Nama produk
            $table->string('slug')->unique(); // Slug untuk produk
            $table->string('brand')->nullable(); // Brand produk
            $table->string('bpom')->nullable(); // No. Bpom
            $table->integer('harga')->nullable(); // Harga produk
            $table->integer('stok')->default(0); // Stok produk
            $table->integer('terjual')->default(0); // Produk terjual
            $table->integer('diskon')->default(0); // Diskon produk
            $table->unsignedBigInteger('id_kategori'); // Gunakan unsignedBigInteger agar sesuai
            $table->foreign('id_kategori')->references('id_kategori')->on('kategori')->onDelete('cascade');
            $table->text('deskripsi')->nullable(); // Deskripsi produk
            $table->text('keyword')->nullable(); // Kata kunci produk
            $table->text('ringkasan')->nullable(); // Ringkasan produk
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
