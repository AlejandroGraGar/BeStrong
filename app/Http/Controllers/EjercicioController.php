<?php

namespace App\Http\Controllers;

use App\Models\Ejercicio;
use Illuminate\Http\Request;
use App\Models\Serie;

class EjercicioController extends Controller
{
    public function index(Request $request)
    {
        $query = Ejercicio::query();
        
        if ($request->filled('search')) {
            $query->where('nombre', 'like', '%' . $request->search . '%');
        }

        $ejercicios = $query->paginate(20)->withQueryString();

        $total_ejercicios = Ejercicio::count();

        return view('ejercicios.index', compact('ejercicios', 'total_ejercicios'));        
    }
    
    public function create()
    {
        //
    }

    public function store(Request $request) 
    {
        //
    }

    public function show(Ejercicio $ejercicio)
    {
        $series = Serie::where('ejercicio_id', $ejercicio->id)
            ->whereHas('entrenamiento', function ($q) {
                $q->where('usuario_id', auth()->id());
            })
            ->with('entrenamiento')
            ->whereNotNull('peso')
            ->get()
            ->sortBy(function ($serie) {
                return $serie->entrenamiento->fecha;
            });

        $labels = $series->map(function ($serie) {
            return \Carbon\Carbon::parse($serie->entrenamiento->fecha)->format('d/m/Y')
                . ' · Serie ' . $serie->numero;
        })->values();

        $data = $series->map(function ($serie) {
            return $serie->peso;
        })->values();

        return view('ejercicios.show', compact('ejercicio', 'labels', 'data'));
    }

    public function edit(Ejercicio $ejercicio) {}

    public function update(Request $request, Ejercicio $ejercicio) {}

    public function destroy(Ejercicio $ejercicio) {}
}