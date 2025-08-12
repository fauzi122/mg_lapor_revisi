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
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->string('subject')->nullable();        
            $table->string('action', 10)->nullable();         
            $table->foreignId('bu_id')->nullable();       
            $table->string('bu_name', 50)->nullable();           
            $table->string('method', 10)->nullable();     
            $table->text('url')->nullable();            
            $table->ipAddress('ip_address')->nullable();  
            $table->text('old_properties')->nullable();   
            $table->text('properties')->nullable();       
            $table->string('description')->nullable();    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
