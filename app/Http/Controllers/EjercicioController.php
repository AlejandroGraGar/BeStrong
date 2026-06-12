<?php

namespace App\Http\Controllers;

use App\Models\Ejercicio;
use Illuminate\Http\Request;
use App\Models\Serie;

class EjercicioController extends Controller
{
    public function index(Request $request)
    {
        $query = Ejercicio::query();

        if ($request->filled('search')) {
            $query->where('nombre', 'like', '%' . $request->search . '%');
        }

        $ejercicios = $query->paginate(20)->withQueryString();
        $total_ejercicios = Ejercicio::count();

        return view('ejercicios.index', compact('ejercicios', 'total_ejercicios'));
    }

    public function create()
    {
        abort_unless(auth()->user()?->is_admin, 403);
        return view('ejercicios.create');
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()?->is_admin, 403);

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|url|max:500',
        ]);

        Ejercicio::create($validated);

        return redirect()->route('ejercicios.index')
            ->with('success', 'Ejercicio creado correctamente.');
    }

    public function show(Ejercicio $ejercicio)
    {
        $series = Serie::where('ejercicio_id', $ejercicio->id)
            ->whereHas('entrenamiento', function ($q) {
                $q->where('usuario_id', auth()->id());
            })
            ->with('entrenamiento')
            ->whereNotNull('peso')
            ->get()
            ->sortBy(fn($s) => $s->entrenamiento->fecha);

        $labels = $series->map(fn($s) =>
            \Carbon\Carbon::parse($s->entrenamiento->fecha)->format('d/m/Y') . ' · Serie ' . $s->numero
        )->values();

        $data = $series->map(fn($s) => $s->peso)->values();

        return view('ejercicios.show', compact('ejercicio', 'labels', 'data'));
    }

    public function edit(Ejercicio $ejercicio)
    {
        abort_unless(auth()->user()?->is_admin, 403);
        return view('ejercicios.edit', compact('ejercicio'));
    }

    public function update(Request $request, Ejercicio $ejercicio)
    {
        abort_unless(auth()->user()?->is_admin, 403);

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|string|max:1000',
        ]);

        $ejercicio->nombre = $validated['nombre'];
        $ejercicio->descripcion = $validated['descripcion'] ?? null;

        if ($request->filled('imagen')) {
            $ejercicio->imagen = $request->imagen;
        } else {
            $ejercicio->imagen = null;
        }

        $ejercicio->save();

        return redirect()->route('ejercicios.index')
            ->with('success', 'Ejercicio actualizado correctamente.');
    }
    public function destroy(Ejercicio $ejercicio)
    {
        abort_unless(auth()->user()?->is_admin, 403);

        $ejercicio->delete();

        return redirect()->route('ejercicios.index')
            ->with('success', 'Ejercicio eliminado correctamente.');
    }
}