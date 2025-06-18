<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIzinMigasTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('izin_migas', function (Blueprint $table) {
            $table->id();
            $table->string('npwp', 20)->index();
            $table->jsonb('data_badan_usaha')->nullable();
            $table->jsonb('data_izin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin_migas');
    }
}
