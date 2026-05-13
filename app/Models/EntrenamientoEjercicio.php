<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntrenamientoEjercicio extends Model
{
    use HasFactory;

    protected $table = 'entrenamiento_ejercicios';

    protected $fillable = [
        'entrenamiento_id',
        'ejercicio_id',
        'series',
        'repeticiones',
        'peso',
        'descanso',
    ];

    public function entrenamiento()
    {
        return $this->belongsTo(Entrenamiento::class);
    }

    public function ejercicio()
    {
        return $this->belongsTo(Ejercicio::class);
    }

    public function series()
    {
        return $this->hasMany(Serie::class);
    }
}