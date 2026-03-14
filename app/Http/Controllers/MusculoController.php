<?php

namespace App\Http\Controllers;

use App\Models\Musculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MusculoController extends Controller
{
    public function index()
    {
        $musculos = Musculo::all();
        return view('musculos.index', compact('musculos'));
    }

    public function create()
    {
        return view('musculos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $musculo = new Musculo();
        $musculo->nombre = $request->nombre;
        $musculo->descripcion = $request->descripcion;

        if ($request->hasFile('imagen')) {
            $ruta = $request->file('imagen')->store('musculos', 'public');
            $musculo->imagen = $ruta;
        }

        $musculo->save();

        return redirect()->route('musculos.index')
            ->with('success', 'Músculo creado correctamente');
    }

    public function edit($id)
    {
        $musculo = Musculo::findOrFail($id);
        return view('musculos.edit', compact('musculo'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $musculo = Musculo::findOrFail($id);

        $musculo->nombre = $request->nombre;
        $musculo->descripcion = $request->descripcion;

        if ($request->hasFile('imagen')) {

            if ($musculo->imagen) {
                Storage::disk('public')->delete($musculo->imagen);
            }

            $ruta = $request->file('imagen')->store('musculos', 'public');
            $musculo->imagen = $ruta;
        }

        $musculo->save();

        return redirect()->route('musculos.index')
            ->with('success', 'Músculo actualizado correctamente');
    }

    public function destroy($id)
    {
        $musculo = Musculo::findOrFail($id);

        if ($musculo->imagen) {
            Storage::disk('public')->delete($musculo->imagen);
        }

        $musculo->delete();

        return redirect()->route('musculos.index')
            ->with('success', 'Músculo eliminado correctamente');
    }
}
