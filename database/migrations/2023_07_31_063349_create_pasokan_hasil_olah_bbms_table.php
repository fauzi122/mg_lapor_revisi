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
        Schema::create('pasokan_hasil_olah_bbms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('badan_usaha_id');
            $table->unsignedBigInteger('izin_id');
            $table->date('tanggal');
            $table->string('bulan', 20);
            $table->string('produk', 100);
            $table->string('provinsi', 30);
            $table->string('kabupaten_kota', 30);
            $table->string('sektor');
            $table->integer('volume');
            $table->string('satuan');
            $table->string('status', 20);
            $table->text('catatan');
            $table->string('petugas', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasokan_hasil_olah_bbms');
    }
};
