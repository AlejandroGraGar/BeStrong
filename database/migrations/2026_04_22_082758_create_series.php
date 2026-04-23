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
        Schema::create('series', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('entrenamiento_ejercicio_id');
            $table->foreign('entrenamiento_ejercicio_id')->references('id')->on('entrenamiento_ejercicios')->onDelete('cascade');
            $table->integer('repeticiones')->nullable();
            $table->float('peso')->nullable();
            $table->boolean('completada')->default(false);

    $table->integer('orden')->nullable();

    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('series');
    }
};
