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
        Schema::create('ejercicio_rutina', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rutina_id');
            $table->foreign('rutina_id')->references('id')->on('rutinas')->cascadeOnDelete();           
            $table->unsignedBigInteger('ejercicio_id');
            $table->foreign('ejercicio_id')->references('id')->on('ejercicios')->cascadeOnDelete();     
            $table->integer('series');
            $table->integer('repeticiones');
            $table->decimal('peso', 6, 2)->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ejercicio_rutinas');
    }
};
