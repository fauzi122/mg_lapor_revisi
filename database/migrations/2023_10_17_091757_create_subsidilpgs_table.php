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
        Schema::create('subsidilpgs', function (Blueprint $table) {
            $table->id();
            $table->date('bulan');
            $table->string('provinsi', 20);
            $table->decimal('volume', 10, 2);
            $table->string('tahun', 4);
            $table->string('kab_kota', 50);
            $table->string('jenis', 20);
            $table->string('status', 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subsidilpgs');
    }
};
