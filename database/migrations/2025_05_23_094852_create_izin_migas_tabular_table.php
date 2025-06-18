<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIzinMigasTabularTable extends Migration
{
    public function up()
    {
        Schema::create('izin_migas_tabular', function (Blueprint $table) {
            $table->id();
            $table->string('npwp')->index(); // tambahkan kolom ini
            $table->string('id_permohonan');
            $table->string('id_izin');
            $table->string('sub_page_id');
            $table->string('nama_tabel');
            $table->text('description')->nullable();
            $table->jsonb('data'); // simpan data tabular bentuk array
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('izin_migas_tabular');
    }
}
