<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entrenamiento;
use App\Models\Ejercicio;
use App\Models\Serie;
use App\Models\DatosUsuario;
use App\Models\Rutina;
use App\Models\User;

class EntrenamientoController extends Controller
{

    public function index()
    {
        $user = auth()->user();
        $datosUsuario = $user->datosUsuario;
        $query = Entrenamiento::where('usuario_id', $user->id)->with('rutina')->orderBy('created_at', 'desc');

        if (!optional($datosUsuario)->premium) {        
            $query->take(10);
        }
        $entrenamientos = $query->get();
        $totalEntrenamientos = Entrenamiento::where('usuario_id', $user->id)->count();
        return view('index', compact('entrenamientos', 'totalEntrenamientos'));
    }

    public function show($id)
    {
        $entrenamiento = Entrenamiento::with(['series.ejercicio','rutina'])->findOrFail($id);
        return view('entrenamientos.show', compact('entrenamiento'));
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {

            $entrenamiento = Entrenamiento::create([
                'usuario_id' => auth()->id(),
                'rutina_id' => null,
                'fecha' => now(),
                'duracion' => $request->duracion ?? 0,
            ]);

            if ($request->has('ejercicios')) {

                foreach ($request->ejercicios as $ejercicio) {

                    if (!isset($ejercicio['ejercicio_id'], $ejercicio['series'])) {
                        continue;
                    }

                    foreach ($ejercicio['series'] as $i => $serie) {

                        Serie::create([
                            'entrenamiento_id' => $entrenamiento->id,
                            'ejercicio_id' => $ejercicio['ejercicio_id'],
                            'numero' => $i + 1,
                            'peso' => $serie['peso'] ?? 0,
                            'repeticiones' => $serie['repeticiones'] ?? 0,
                        ]);
                    }
                }
            }

            return redirect()->route('entrenamientos.show', $entrenamiento->id);
        }

        $ejercicios = Ejercicio::all();

        return view('entrenamientos.create', compact('ejercicios'));
    }

    public function startRutina(Request $request, Rutina $rutina)
    {
        if ($request->isMethod('post')) {

            $entrenamiento = Entrenamiento::create([
                'usuario_id' => auth()->id(),
                'rutina_id' => $rutina->id,
                'fecha' => now(),
                'duracion' => 0,
            ]);

            if ($request->has('ejercicios')) {

                foreach ($request->ejercicios as $ejercicioId => $series) {

                    foreach ($series as $numeroSerie => $datos) {

                        Serie::create([
                            'entrenamiento_id' => $entrenamiento->id,
                            'ejercicio_id' => $ejercicioId,
                            'numero' => $numeroSerie,
                            'peso' => $datos['peso'] ?? 0,
                            'repeticiones' => $datos['repeticiones'] ?? 0,
                        ]);
                    }
                }
            }

            return redirect()->route('entrenamientos.show', $entrenamiento);
        }

        $rutina->load('ejercicios');

        return view('rutinas.start', compact('rutina'));
    }

 /*   public function progreso(Request $request, $id)
    {
        $entrenamiento = Entrenamiento::with('ejercicios')->findOrFail($id);

        foreach ($request->ejercicios as $ejercicioId => $series) {

            foreach ($series as $numeroSerie => $datos) {
                $entrenamiento->ejercicios()->updateExistingPivot($ejercicioId, [
                    'repeticiones' => $datos['repeticiones'] ?? null,
                    'peso' => $datos['peso'] ?? null,
                ]);
            }
        }

        return redirect()->route('entrenamientos.index')->with('success', 'Progreso guardado correctamente');
    }

    public function update(Request $request, $id)
    {
        $entrenamiento = Entrenamiento::findOrFail($id);

        if ($request->isMethod('post')) {
            $entrenamiento->usuario_id = auth()->id();
            $entrenamiento->rutina_id = $request->rutina_id;
            $entrenamiento->fecha = $request->fecha;
            $entrenamiento->duracion = $request->duracion;
            $entrenamiento->save();

            return redirect()->route('entrenamientos.index')->with('success', 'Entrenamiento actualizado correctamente');
        }

        $ejercicios = Ejercicio::all();

        return view('entrenamientoEjercicio.edit', compact('entrenamiento', 'ejercicios'));
    }
*/
    public function start(Rutina $rutina)
    {
        $rutina->load('ejercicios');

        $entrenamiento = \App\Models\Entrenamiento::create([
            'usuario_id' => auth()->id(),
            'rutina_id' => $rutina->id,
            'inicio' => now(),
            'fecha' => now(),
            'duracion' => 0,
        ]);


        foreach ($rutina->ejercicios as $ejercicio) {
            $entrenamiento->ejercicios()->attach($ejercicio->id, [
                'series' => $ejercicio->pivot->series,
                'repeticiones' => $ejercicio->pivot->repeticiones,
                'peso' => $ejercicio->pivot->peso,
            ]);
        }

        return redirect()->route('entrenamientos.show', $entrenamiento);
    }


    public function delete($id)
    {
        $entrenamiento = Entrenamiento::findOrFail($id);
        $entrenamiento->delete();

        return redirect()->route('entrenamientos.index')->with('success', 'Entrenamiento eliminado correctamente');
    }
}
