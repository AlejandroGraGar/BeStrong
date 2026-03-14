<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'password',
        'sexo',
        'fecha_nacimiento',
        'altura',
        'peso'
    ];

    protected $hidden = [
        'password'
    ];


    public function objetivos()
    {
        return $this->hasMany(Objetivo::class);
    }

    public function entrenamientos()
    {
        return $this->hasMany(Entrenamiento::class);
    }
}
