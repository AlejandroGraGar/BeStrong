<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ejercicio extends Model
{
     protected $fillable = [
        'nombre',
        'descripcion',
        'video',
        'series',
        'repeticiones',
        'descanso'
    ];

    public function rutinas()
    {
        return $this->belongsToMany(Rutina::class)->withPivot('orden')->withTimestamps();
    }

    public function musculos()
    {
        return $this->belongsToMany(Musculo::class);
    }

    public function equipamientos()
    {
        return $this->belongsToMany(Equipamiento::class);
    }
}
