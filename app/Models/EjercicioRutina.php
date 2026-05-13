<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EjercicioRutina extends Pivot
{
    protected $table = 'ejercicio_rutina';

    protected $fillable = [
        'rutina_id',
        'ejercicio_id',
        'series',
        'repeticiones',
        'peso',
    ];


    public function ejercicios()
    {
        return $this->belongsToMany(Ejercicio::class)
            ->using(EjercicioRutina::class)
            ->withPivot('series', 'repeticiones', 'peso')
            ->withTimestamps();
    }
    public function rutinas()
    {
        return $this->belongsToMany(Rutina::class)
            ->using(EjercicioRutina::class)
            ->withPivot('series', 'repeticiones', 'peso')
            ->withTimestamps();
    }


}
