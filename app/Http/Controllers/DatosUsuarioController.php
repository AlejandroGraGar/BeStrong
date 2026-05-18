<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DatosUsuario;
use Illuminate\Support\Facades\Auth;

class DatosUsuarioController extends Controller
{
    public function index()
    {
        $datosUsuario = DatosUsuario::where('user_id', Auth::id())->first();
        return view('datos_usuarios.index', compact('datosUsuario'));
    }

    public function create(Request $request)
    {
        $datosUsuario = DatosUsuario::where('user_id', Auth::id())->first();

        if ($datosUsuario) {
            return redirect()->route('datos_usuarios.index');
        }

        if ($request->isMethod('post')) {

            $validados = $request->validate([
                'nombre' => 'required|string|max:255',
                'apellido' => 'required|string|max:255',
                'sexo' => 'required|string',
                'fecha_nacimiento' => 'required|date',
                'altura' => 'required|string',
                'peso' => 'required|string',
                'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);

            $validados['user_id'] = Auth::id();

            if ($request->hasFile('imagen')) {
                $validados['imagen'] = $request->file('imagen')->store('usuarios', 'public');
            }

            DatosUsuario::create($validados);

            return redirect()
                ->route('datos_usuarios.index')
                ->with('success', 'Datos creados correctamente');
        }

        return view('datos_usuarios.create');
    }

    public function update(Request $request, $id)
    {
        $datosUsuario = DatosUsuario::findOrFail($id);

        if ($request->isMethod('put')) {

            $request->validate([
                'nombre' => 'required|string|max:255',
                'apellido' => 'required|string|max:255',
                'sexo' => 'required|in:Masculino,Femenino,Otro',
                'fecha_nacimiento' => 'nullable|date',
                'altura' => 'nullable|numeric',
                'peso' => 'nullable|numeric',
                'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);

            $data = [
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'sexo' => $request->sexo,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'altura' => $request->altura,
                'peso' => $request->peso,
            ];

            if ($request->hasFile('imagen')) {
                $data['imagen'] = $request->file('imagen')->store('usuarios', 'public');
            }

            $datosUsuario->update($data);

            return redirect()
                ->route('datos_usuarios.index')
                ->with('success', 'Perfil actualizado correctamente');
        }

        return view('datos_usuarios.edit', compact('datosUsuario'));
    }
}