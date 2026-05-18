<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ejercicio extends Model
{
     protected $fillable = [
        'nombre',
        'descripcion',
        'video_url',
        'series',
        'repeticiones',
        'descanso'
    ];

    public function rutinas()
    {
        return $this->belongsToMany(Rutina::class)->withPivot('orden')->withTimestamps();
    }
 
    public function entrenamientos()
    {
        return $this->belongsToMany(Entrenamiento::class, 'ejercicio_entrenamiento')
            ->withPivot('series', 'repeticiones', 'peso')
            ->withTimestamps();
    }

    public function series()
{
    return $this->hasMany(Serie::class);
}


}
