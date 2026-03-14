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
        return $this->belongsTo(Usuario::class);
    }

    public function rutina()
    {
        return $this->belongsTo(Rutina::class);
    }
}
