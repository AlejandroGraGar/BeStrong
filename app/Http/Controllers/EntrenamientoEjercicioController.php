<?php

namespace App\Http\Controllers;

use App\Models\Ejercicio;
use App\Models\EntrenamientoEjercicio;
use App\Models\Entrenamiento;
use Illuminate\Http\Request;

class EntrenamientoEjercicioController extends Controller
{
    public function index()
    {
        return response()->json(EntrenamientoEjercicio::all());
    }
 
    public function create(Request $request)
    {
        if ($request->isMethod('post')) {

            $validated = $request->validate([
                'entrenamiento_id' => 'nullable|exists:entrenamientos,id',
            ]);

            if (!$validated['entrenamiento_id']) {
                $entrenamiento = Entrenamiento::create([
                    'usuario_id' => auth()->id(),
                    'fecha' => now(),
                    'duracion' => 0,
                ]);

                $validated['entrenamiento_id'] = $entrenamiento->id;
            }

            foreach ($request->ejercicios as $ejercicio) {

                if (!isset($ejercicio['series']) || !is_array($ejercicio['series'])) {
                    continue;
                }

                foreach ($ejercicio['series'] as $i => $serie) {

                    EntrenamientoEjercicio::create([
                        'entrenamiento_id' => $validated['entrenamiento_id'],
                        'ejercicio_id' => $ejercicio['id'],
                        'series' => $serie,
                        'repeticiones' => $serie,
                        'peso' => $ejercicio['peso'][$i] ?? null,
                    ]);
                }
            }


            return redirect()->route('home')
                ->with('success', 'Ejercicio añadido al entrenamiento');
        }

        $entrenamiento_id = $request->entrenamiento_id;
        $ejercicios = Ejercicio::all();

        return view('entrenamientoEjercicio.create', compact('ejercicios', 'entrenamiento_id'));
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