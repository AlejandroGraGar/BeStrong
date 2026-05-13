<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\DatosUsuario; 
use App\Models\User;
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
                'user_id' => 'exists:users,id',
                'nombre' => 'required|string|max:255',
                'apellido' => 'required|string|max:255',
                'sexo' => 'required|string',
                'fecha_nacimiento' => 'required|date',
                'altura' => 'required|string',
                'peso' => 'required|string',
            ]);
            $validados['user_id'] = Auth::id();

            DatosUsuario::create($validados);

            return redirect()->route('datos_usuarios.index')->with('success', 'Datos actualizados correctamente');
        }
    
        return view('datos_usuarios.create');
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


}