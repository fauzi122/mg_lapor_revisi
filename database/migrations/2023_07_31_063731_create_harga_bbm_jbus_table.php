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
        Schema::create('harga_bbm_jbus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('badan_usaha_id');
            $table->unsignedBigInteger('izin_id');
            $table->string('bulan', 20);
            $table->string('produk', 100);
            $table->string('sektor');
            $table->string('provinsi', 30);
            $table->integer('volume');
            $table->decimal('biaya_perolehan', 10, 2);
            $table->decimal('biaya_distribusi', 10, 2);
            $table->decimal('biaya_penyimpanan', 10, 2);
            $table->decimal('margin', 10, 2);
            $table->decimal('ppn', 10, 2);
            $table->decimal('pbbkp', 10, 2);
            $table->decimal('harga_jual', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('harga_bbm_jbus');
    }
};
