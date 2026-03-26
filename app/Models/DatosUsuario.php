<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DatosUsuario extends Model
{
    protected $table = 'datos_usuarios';

    protected $fillable = [
        'nombre',
        'apellido',
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
