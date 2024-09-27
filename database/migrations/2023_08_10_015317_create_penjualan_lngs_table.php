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
        Schema::create('penjualan_lngs', function (Blueprint $table) {
            $table->id();
            $table->string('bulan', 20);
            $table->string('provinsi', 30);
            $table->string('kabupaten_kota', 30);
            $table->string('produk', 100);
            $table->string('konsumen', 100);
            $table->string('sektor');
            $table->integer('volume');
            $table->string('satuan');
            $table->decimal('biaya_kompresi', 10, 2);
            $table->decimal('biaya_penyimpanan', 10, 2);
            $table->decimal('biaya_pengangkutan', 10, 2);
            $table->decimal('biaya_niaga', 10, 2);
            $table->decimal('harga_jual', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan_lngs');
    }
};
