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
        Schema::create('penygasbumis', function (Blueprint $table) {
            $table->id();
            $table->string('bulan', 20);
            $table->string('no_tangki', 20);
            $table->string('produk', 20);
            $table->string('kab_kota', 20);
            $table->decimal('volume_stok_awal', 10, 2);
            $table->decimal('volume_supply', 10, 2);
            $table->decimal('volume_output', 10, 2);
            $table->decimal('volume_stok_akhir', 10, 2);
            $table->string('satuan', 20);
            $table->string('utilasi_tangki', 20);
            $table->string('pengguna', 20);
            $table->string('jangka_waktu_penggunaan', 20);
            $table->decimal('tarif_penyimpanan', 10, 2);
            $table->string('satuan_tarif', 20);
            $table->string('status', 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penygasbumis');
    }
};
