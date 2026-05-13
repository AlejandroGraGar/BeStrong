<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DatosUsuario;
use App\Models\Rutina;
use Illuminate\Support\Facades\Auth;


class RutinaController extends Controller
{
    public function index()
    {
        $rutinas = Rutina::where('usuario_id', auth()->id())->get();
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
            
            $request->validate([
                'nombre' => 'required|string|max:255',
                'descripcion' => 'nullable|string',
            ]);

            $rutina = Rutina::create([
            'usuario_id' => Auth::id(),
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            ]);

            return redirect()->route('ejercicioRutina.create', $rutina->id)
                ->with('success', 'Rutina creada correctamente');

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
