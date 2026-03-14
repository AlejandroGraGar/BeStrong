<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entrenamiento;
use App\Models\Usuario;
use App\Models\Rutina;

class EntrenamientoController extends Controller
{

    public function index()
    {
        $entrenamientos = Entrenamiento::with(['usuario', 'rutina'])->orderBy('fecha', 'desc')->get();
        return view('entrenamientos.index', compact('entrenamientos'));
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
            $entrenamiento->usuario_id = $request->usuario_id;
            $entrenamiento->rutina_id = $request->rutina_id;
            $entrenamiento->fecha = $request->fecha;
            $entrenamiento->duracion = $request->duracion;
            $entrenamiento->save();

            return redirect()->route('entrenamientos.index')->with('success', 'Entrenamiento creado correctamente');
        }

        $usuarios = Usuario::all();
        $rutinas = Rutina::all();
        return view('entrenamientos.create', compact('usuarios', 'rutinas'));
    }

    public function update(Request $request, $id)
    {
        $entrenamiento = Entrenamiento::findOrFail($id);

        if ($request->isMethod('post')) {
            $datosEntrenamiento = $request->validate([
                'usuario_id' => 'required|exists:usuarios,id',
                'rutina_id' => 'required|exists:rutinas,id',
                'fecha' => 'required|date',
                'duracion' => 'required|integer|min:1',
            ]);

            $entrenamiento->update($datosEntrenamiento);

            return redirect()->route('entrenamientos.index')->with('success', 'Entrenamiento actualizado correctamente');
        }

        $usuarios = Usuario::all();
        $rutinas = Rutina::all();
        return view('entrenamientos.edit', compact('entrenamiento', 'usuarios', 'rutinas'));
    }

     public function delete($id)
    {
        $entrenamiento = Entrenamiento::findOrFail($id);
        $entrenamiento->delete();

        return redirect()->route('entrenamientos.index')->with('success', 'Entrenamiento eliminado correctamente');
    }
}
