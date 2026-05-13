<?php

namespace App\Http\Controllers;

use App\Models\EjercicioRutina;
use App\Models\Rutina;
use App\Models\Ejercicio;
use Illuminate\Http\Request;

class EjercicioRutinaController extends Controller
{
    public function show($id)
    {
        $rutina = Rutina::with('ejercicios')->findOrFail($id);

        return view('rutinas.show', compact('rutina'));
    }

    public function create(Request $request, Rutina $rutina)
    {
        if ($request->isMethod('post')) {

            $request->validate([
                'ejercicios' => 'nullable|array',
            ]);

            foreach ($request->ejercicios as $id => $data) {

                if (isset($data['selected'])) {

                    $rutina->ejercicios()->attach($id, [
                        'series' => $data['series'] ?? 3,
                        'repeticiones' => $data['repeticiones'] ?? 10,
                        'peso' => $data['peso'] ?? null,
                        'notas' => $data['notas'] ?? null,
                    ]);
                }
            }

            return redirect()->route('rutinas.index', $rutina);
        }

        $ejerciciosDisponibles = Ejercicio::whereNotIn('id',$rutina->ejercicios->pluck('id'))->get();

        return view('ejercicio_rutina.create', compact('rutina', 'ejerciciosDisponibles'));
    }


    public function update(Request $request, Rutina $rutina)
    {
        if ($request->isMethod('put')) {

            $enviados = collect($request->ejercicios ?? []);
            $syncData = [];

            foreach ($enviados as $ejercicioId => $data) {
                if (isset($data['selected'])) {
                    $syncData[$ejercicioId] = [
                        'series' => $data['series'] ?? 3,
                        'repeticiones' => $data['repeticiones'] ?? 10,
                        'peso' => $data['peso'] ?? null,
                        'notas' => $data['notas'] ?? null,
                    ];
                }
            }

            $rutina->ejercicios()->sync($syncData);

            return redirect()->route('rutinas.index', $rutina)
                ->with('success', 'Rutina actualizada correctamente');
        }

        $rutina->load('ejercicios');
        $ejercicios = Ejercicio::all();

        return view('ejercicio_rutina.edit', compact('rutina', 'ejercicios'));
    }



    public function destroy(Rutina $rutina, Ejercicio $ejercicio)
    {
        $rutina->ejercicios()->detach($ejercicio->id);
        return redirect()->route('rutinas.show', $rutina)->with('success', 'Ejercicio eliminado de la rutina');
    }

    
}