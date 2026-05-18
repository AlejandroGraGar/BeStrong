<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    protected $table = 'series';

    protected $fillable = [
        'entrenamiento_id',
        'ejercicio_id',
        'numero',
        'peso',
        'repeticiones',
    ];



    public function entrenamiento()
    {
        return $this->belongsTo(Entrenamiento::class);
    }

    public function ejercicio()
    {
        return $this->belongsTo(Ejercicio::class);
    }
}
