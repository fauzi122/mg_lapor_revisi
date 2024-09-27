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
        Schema::create('kuota_lpg_subsidis', function (Blueprint $table) {
            $table->id();
            $table->year('tahun');       
            $table->text('provinsi');    
            $table->text('kabupaten/kota');  
            $table->decimal('volume', 8, 2); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kuota_lpg_subsidis');
    }
};
