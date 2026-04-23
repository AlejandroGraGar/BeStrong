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
                        'orden' => $data['orden'] ?? 0,
                        'notas' => $data['notas'] ?? null,
                    ]);
                }
            }

            return redirect()->route('rutinas.index', $rutina);
        }

        $ejerciciosDisponibles = Ejercicio::whereNotIn(
            'id',
            $rutina->ejercicios->pluck('id')
        )->get();

        return view('ejercicio_rutina.create', compact('rutina', 'ejerciciosDisponibles'));
    }


    public function edit(Request $request, Rutina $rutina)
    {
        if ($request->isMethod('put')) {

            $enviados = collect($request->ejercicios ?? []);

            $idsEnviados = $enviados->keys()->map(fn ($id) => (int) $id)->toArray();

            $rutina->ejercicios()
                ->wherePivotNotIn('ejercicio_id', $idsEnviados)
                ->detach();

            foreach ($enviados as $ejercicioId => $data) {

                $rutina->ejercicios()->syncWithoutDetaching([
                    $ejercicioId => [
                        'series' => $data['series'] ?? 3,
                        'repeticiones' => $data['repeticiones'] ?? 10,
                        'peso' => $data['peso'] ?? null,
                        'orden' => $data['orden'] ?? 0,
                        'notas' => $data['notas'] ?? null,
                    ]
                ]);
            }

            return redirect()
                ->route('rutinas.show', $rutina)
                ->with('success', 'Rutina actualizada correctamente');
        }

        $ejerciciosDisponibles = \App\Models\Ejercicio::all();
        $ejerciciosActuales = $rutina->ejercicios;

        return view('ejercicio_rutina.edit', compact('rutina', 'ejerciciosDisponibles', 'ejerciciosActuales'));
    }



    public function destroy(Rutina $rutina, Ejercicio $ejercicio)
    {
        $rutina->ejercicios()->detach($ejercicio->id);
        return redirect()->route('rutinas.show', $rutina)->with('success', 'Ejercicio eliminado de la rutina');
    }

    
}