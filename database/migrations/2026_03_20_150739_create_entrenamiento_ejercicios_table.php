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
        Schema::create('entrenamiento_ejercicios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('entrenamiento_id');
            $table->unsignedBigInteger('ejercicio_id');
            $table->foreign('entrenamiento_id')->references('id')->on('entrenamientos');
            $table->foreign('ejercicio_id')->references('id')->on('ejercicios');
            $table->integer('series'); 
            $table->integer('repeticiones');
            $table->float('peso')->nullable();
            $table->integer('descanso')->nullable();
            $table->timestamps();
                
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entrenamiento_ejercicios');
    }
};
