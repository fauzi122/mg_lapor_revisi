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
        Schema::create('profil_admins', function (Blueprint $table) {
            $table->id();
            $table->char('nip',20);
            $table->char('nik',16);       
            $table->string('email',100);    
            $table->string('tingkat',100);    
            $table->string('name',100);    
            $table->string('id_jabatan',10);    
            $table->char('tte',10);    
            $table->char('sso',10);    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_admins');
    }
};
