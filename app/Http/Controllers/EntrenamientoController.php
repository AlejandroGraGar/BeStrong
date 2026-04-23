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
        $entrenamientos = Entrenamiento::where('usuario_id', auth()->id())->orderBy('fecha', 'desc')->get();

        return view('index', compact('entrenamientos'));

    }

    public function show($id)
    {
        $entrenamiento = Entrenamiento::with(['usuario', 'rutina'])->findOrFail($id);
        return view('entrenamientos.show', compact('entrenamiento'));
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


     public function delete($id)
    {
        $entrenamiento = Entrenamiento::findOrFail($id);
        $entrenamiento->delete();

        return redirect()->route('entrenamientos.index')->with('success', 'Entrenamiento eliminado correctamente');
    }
}
