<?php

namespace App\Http\Controllers;

use App\Models\EntrenamientoEjercicio;
use Illuminate\Http\Request;

class EntrenamientoEjercicioController extends Controller
{
    public function index()
    {
        return response()->json(EntrenamientoEjercicio::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'entrenamiento_id' => 'required|exists:entrenamientos,id',
            'ejercicio_id'     => 'required|exists:ejercicios,id',
            'series'           => 'required|integer',
            'repeticiones'     => 'required|integer',
            'peso'             => 'nullable|numeric',
            'descanso'         => 'nullable|integer',
        ]);

        $registro = EntrenamientoEjercicio::create($validated);

        return response()->json([
            'message' => 'Ejercicio añadido al entrenamiento',
            'data' => $registro
        ], 210);
    }

    public function show($id)
    {
        $registro = EntrenamientoEjercicio::findOrFail($id);
        return response()->json($registro);
    }

    public function update(Request $request, $id)
    {
        $registro = EntrenamientoEjercicio::findOrFail($id);

        $validated = $request->validate([
            'series'       => 'integer',
            'repeticiones' => 'integer',
            'peso'         => 'nullable|numeric',
            'descanso'     => 'nullable|integer',
        ]);

        $registro->update($validated);

        return response()->json([
            'message' => 'Registro actualizado correctamente',
            'data' => $registro
        ]);
    }

    public function destroy($id)
    {
        $registro = EntrenamientoEjercicio::findOrFail($id);
        $registro->delete();

        return response()->json([
            'message' => 'Ejercicio eliminado del entrenamiento'
        ]);
    }
}