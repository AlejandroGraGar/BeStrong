<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Objetivo extends Model
{
    protected $fillable = [
        'usuario_id',
        'nombre',
        'descripcion',
        'meta_peso',
        'fecha_inicio',
        'fecha_fin'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}
