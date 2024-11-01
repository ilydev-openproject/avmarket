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
        Schema::create('product_tag', function (Blueprint $table) {
            $table->foreignId('id_product')->constrained('products')->onDelete('cascade');
            $table->foreignId('id_tag')->constrained('tags')->onDelete('cascade');
            $table->primary(['id_product', 'id_tag']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_tag');
    }
};
