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
        Schema::create('email_masters', function (Blueprint $table) {
            $table->id();
            $table->string('subject')->nullable();
            $table->text('content')->nullable();
            $table->enum('event', ['SUBMIT', 'REVISI', 'PERBAIKAN']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_masters');
    }
};
