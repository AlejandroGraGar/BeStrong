<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use Illuminate\Http\Request;

class SerieController extends Controller
{
    public function store(Request $request)
    {
        foreach ($request->series as $serie) {
            Serie::create([
                'entrenamiento_id' => $request->entrenamiento_id,
                'ejercicio_id' => $serie['ejercicio_id'],
                'numero' => $serie['numero'],
                'peso' => $serie['peso'],
                'repeticiones' => $serie['repeticiones']
            ]);
        }
        return back();
    }
}

