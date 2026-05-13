<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entrenamiento extends Model
{
     protected $fillable = [
        'usuario_id',
        'rutina_id',
        'fecha',
        'duracion'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function ejercicios()
    {
        return $this->belongsToMany(Ejercicio::class,'entrenamiento_ejercicios','entrenamiento_id','ejercicio_id')
        ->withPivot('series','repeticiones','peso')
        ->withTimestamps();
    }




    public function rutina()
    {
        return $this->belongsTo(Rutina::class);
    }
}
