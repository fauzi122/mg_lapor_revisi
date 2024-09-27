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
        Schema::create('mepings', function (Blueprint $table) {
            $table->id();
            $table->string('id_sub_page', 11);
            $table->string('id_template', 11);
            $table->string('nama_opsi', 200);
            $table->string('kategori', 20);
            $table->string('sts', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mepings');
    }
};
