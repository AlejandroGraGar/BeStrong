<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    protected $table = 'series';

    protected $fillable = [
        'entrenamiento_ejercicio_id',
        'repeticiones',
        'peso',
        'completada',
    ];

    public function entrenamientoEjercicio()
    {
        return $this->belongsTo(EntrenamientoEjercicio::class);
    }

    public function entrenamiento()
    {
        return $this->hasOneThrough(
            Entrenamiento::class,
            EntrenamientoEjercicio::class,
            'id',
            'id',
            'entrenamiento_ejercicio_id',
            'entrenamiento_id'
        );
    }

    public function ejercicio()
    {
        return $this->hasOneThrough(
            Ejercicio::class,
            EntrenamientoEjercicio::class,
            'id',
            'id',
            'entrenamiento_ejercicio_id',
            'ejercicio_id'
        );
    }
}
