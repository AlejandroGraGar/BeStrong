<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Musculo extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'imagen'
    ];

    public function ejercicios()
    {
        return $this->belongsToMany(Ejercicio::class);
    }
}
