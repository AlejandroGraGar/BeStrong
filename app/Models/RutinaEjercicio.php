<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RutinaEjercicio extends Model
{
     protected $table = 'rutina_ejercicio';

    protected $fillable = [
        'rutina_id',
        'ejercicio_id',
        'orden'
    ];
}
