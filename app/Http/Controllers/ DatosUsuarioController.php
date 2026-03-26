<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DatosUsuario; // Asegúrate de tener este modelo creado
use App\Models\User;

class DatosUsuarioController extends Controller
{
    public function index()
    {
        // Obtenemos los datos con la relación del usuario de la tabla 'users'
        $datosUsuarios = DatosUsuario::with('user')->get();
        return view('datos_usuarios.index', compact('datosUsuarios'));
    }

    public function show($id)
    {
        $datosUsuario = DatosUsuario::with('user')->findOrFail($id);
        return view('datos_usuarios.show', compact('datosUsuario'));
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $datos = $request->validate([
                'user_id' => 'required|exists:users,id',
                'nombre' => 'required|string|max:255',
                'apellido' => 'required|string|max:255',
                'sexo' => 'required|string',
                'fecha_nacimiento' => 'required|date',
                'altura' => 'required|string',
                'peso' => 'required|string',
            ]);

            $datosUsuario = new DatosUsuario();
            $datosUsuario->user_id = $request->user_id;
            $datosUsuario->nombre = $request->nombre;
            $datosUsuario->apellido = $request->apellido;
            $datosUsuario->sexo = $request->sexo;
            $datosUsuario->fecha_nacimiento = $request->fecha_nacimiento;
            $datosUsuario->altura = $request->altura;
            $datosUsuario->peso = $request->peso;
            $datosUsuario->save();

            return redirect()->route('datos_usuarios.index')->with('success', 'Datos de usuario creados correctamente');
        }

        $users = User::all();
        return view('datos_usuarios.create', compact('users'));
    }

    public function update(Request $request, $id)
    {
        $datosUsuario = DatosUsuario::findOrFail($id);

        if ($request->isMethod('post')) {
            $validados = $request->validate([
                'user_id' => 'required|exists:users,id',
                'nombre' => 'required|string|max:255',
                'apellido' => 'required|string|max:255',
                'sexo' => 'required|string',
                'fecha_nacimiento' => 'required|date',
                'altura' => 'required|string',
                'peso' => 'required|string',
            ]);

            $datosUsuario->update($validados);

            return redirect()->route('datos_usuarios.index')->with('success', 'Datos actualizados correctamente');
        }

        $users = User::all();
        return view('datos_usuarios.edit', compact('datosUsuario', 'users'));
    }

    public function delete($id)
    {
        $datosUsuario = DatosUsuario::findOrFail($id);
        $datosUsuario->delete();

        return redirect()->route('datos_usuarios.index')->with('success', 'Datos eliminados correctamente');
    }
}