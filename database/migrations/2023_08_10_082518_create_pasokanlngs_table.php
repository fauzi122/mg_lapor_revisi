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
        Schema::create('pasokanlngs', function (Blueprint $table) {
            $table->id();
            $table->string('bulan', 20);
            $table->string('produk', 100);
            $table->string('nama_pemasok', 100);
            $table->string('kategori_pemasok', 100);
            $table->integer('volume');
            $table->string('satuan');
            $table->integer('harga_gas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasokanlngs');
    }
};
