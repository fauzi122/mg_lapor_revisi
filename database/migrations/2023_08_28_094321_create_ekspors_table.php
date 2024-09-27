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
        Schema::create('ekspors', function (Blueprint $table) {
            $table->id();
            $table->string('bulan_peb', 20);
            $table->string('produk', 30);
            $table->decimal('hs_code', 10, 2);
            $table->decimal('volume_peb', 10, 2);
            $table->string('satuan', 30);
            $table->decimal('invoice_amount_nilai_pabean', 10, 2);
            $table->decimal('invoice_amount_final', 10, 2);
            $table->string('nama_konsumen', 30);
            $table->string('pelabuhan_muat', 30);
            $table->string('negara_tujuan', 30);
            $table->string('vessel_name', 30);
            $table->date('tanggal_bl', 30);
            $table->string('bl_no', 30);
            $table->string('no_pendaf_peb', 30);
            $table->date('tanggal_pendaf_peb', 30);
            $table->string('incoterms', 30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ekspors');
    }
};
