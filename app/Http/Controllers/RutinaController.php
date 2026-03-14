<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rutina;

class RutinaController extends Controller
{
    public function index()
    {
        $rutinas = Rutina::orderBy('id', 'desc')->get();
        return view('rutinas.index', compact('rutinas'));
    }
        
    public function show($id)
    {
        $rutina = Rutina::findOrFail($id);
        return view('rutinas.show', compact('rutina'));
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $rutina = new Rutina();
            $rutina->nombre = $request->nombre;
            $rutina->descripcion = $request->descripcion;
            $rutina->save();

            return redirect()->route('rutinas.index')->with('success', 'Rutina creada correctamente');
        }

        return view('rutinas.create');
    }

    public function update(Request $request, $id)
    {
        $rutina = Rutina::findOrFail($id);

        if ($request->isMethod('post')) {
            $rutina->nombre = $request->nombre;
            $rutina->descripcion = $request->descripcion;
            $rutina->save();

            return redirect()->route('rutinas.index')->with('success', 'Rutina actualizada correctamente');
        }

        return view('rutinas.edit', compact('rutina'));
    }

    public function delete($id)
    {
        $rutina = Rutina::findOrFail($id);
        $rutina->delete();

        return redirect()->route('rutinas.index')->with('success', 'Rutina eliminada correctamente');
    }

}
