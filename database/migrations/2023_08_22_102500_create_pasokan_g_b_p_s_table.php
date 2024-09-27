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
        Schema::create('pasokan_g_b_p_s', function (Blueprint $table) {
            $table->id();
            $table->string('bulan', 20);
            $table->string('nama_pemasok', 50);
            $table->decimal('volume_mmbtu', 10, 2);
            $table->decimal('volume_mscf', 10, 2);
            $table->decimal('volume_m3', 10, 2);
            $table->decimal('harga', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasokan_g_b_p_s');
    }
};
