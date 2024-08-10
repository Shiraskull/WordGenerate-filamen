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
        Schema::create('word_gnerates', function (Blueprint $table) {
            $table->id();
            $table->string('kabupaten');
            // $table->date('tanggal');
            // $table->string('foto_dinas');
            // $table->string('kepala_dinas');
            $table->text('latar_belakang');
            $table->text('tujuan');
            $table->text('strategis');
            $table->text('demografi');
            $table->string('path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('word_gnerates');
    }
};
