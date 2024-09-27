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
        Schema::create('penjualan_g_b_p_s', function (Blueprint $table) {
            $table->id();
            $table->string('bulan', 20);
            $table->string('provinsi', 30);
            $table->string('kabupaten_kota', 30);
            $table->string('sektor');
            $table->string('konsumen', 30);
            $table->decimal('jumlah_hari_penyaluran', 10, 2);
            $table->decimal('ghv', 10, 2);
            $table->decimal('volume_mmbtu', 10, 2);
            $table->decimal('volume_mscf', 10, 2);
            $table->decimal('volume_m3', 10, 2);
            $table->decimal('harga', 10, 2);
            $table->string('keterangan', 200);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan_g_b_p_s');
    }
};
