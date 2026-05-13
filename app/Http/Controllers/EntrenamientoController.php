<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entrenamiento;
use App\Models\Ejercicio;
use App\Models\DatosUsuario;
use App\Models\Rutina;
use App\Models\User;

class EntrenamientoController extends Controller
{

    public function index()
    {
        $entrenamientos = Entrenamiento::where('usuario_id', auth()->id())->with('rutina')->orderBy('created_at', 'desc')->get();
        $totalEntrenamientos = $entrenamientos->count();
        return view('index', compact('entrenamientos', 'totalEntrenamientos'));
    }

    public function show($id)
    {
        $entrenamiento = Entrenamiento::with('ejercicios')->findOrFail($id);

        $ejercicios = Ejercicio::all();

        return view('entrenamientos.show', compact('entrenamiento','ejercicios')); 
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $entrenamiento = new Entrenamiento();
            $entrenamiento->usuario_id = auth()->id(); 
            $entrenamiento->rutina_id = $request->rutina_id;
            $entrenamiento->fecha = $request->fecha;
            $entrenamiento->duracion = $request->duracion;
            $entrenamiento->save();

            return redirect()->route('entrenamientos.index');
        }
    
        $ejercicios = Ejercicio::all();


        return view('entrenamientoEjercicio.create', compact('ejercicios'));
    }

    public function startRutina(Rutina $rutina)
    {
        $entrenamiento = Entrenamiento::create([
            'usuario_id' => auth()->id(),
            'rutina_id' => $rutina->id,
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

        $entrenamiento->load('rutina', 'ejercicios');

        return view('rutinas.start', compact('entrenamiento'));
    }

    public function progreso(Request $request, $id)
    {
        $entrenamiento = Entrenamiento::with('ejercicios')->findOrFail($id);

        foreach ($request->ejercicios as $ejercicioId => $series) {

            foreach ($series as $numeroSerie => $datos) {

                // Aquí guardas cada serie
                $entrenamiento->ejercicios()->updateExistingPivot($ejercicioId, [
                    'repeticiones' => $datos['repeticiones'] ?? null,
                    'peso' => $datos['peso'] ?? null,
                ]);
            }
        }

        return redirect()
            ->route('entrenamientos.index')
            ->with('success', 'Progreso guardado correctamente');
    }
/*
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
