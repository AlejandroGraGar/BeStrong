<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rutina extends Model
{
    protected $fillable = [
        'usuario_id',
        'nombre',
        'descripcion'
    ];


    public function entrenamientos()
    {
        return $this->hasMany(Entrenamiento::class);
    }

    public function ejercicios()
    {
        return $this->belongsToMany(Ejercicio::class)->withPivot('orden')->withTimestamps();
    }
}
