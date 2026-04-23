<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ejercicio_musculo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ejercicio_id');
            $table->unsignedBigInteger('musculo_id');
            $table->enum('tipo', ['principal', 'secundario'])->nullable();
            $table->timestamps();
            $table->foreign('ejercicio_id')->references('id')->on('ejercicios')->onDelete('cascade');
            $table->foreign('musculo_id')->references('id')->on('musculos')->onDelete('cascade');
            $table->unique(['ejercicio_id', 'musculo_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ejercicio_musculo');
    }
};
