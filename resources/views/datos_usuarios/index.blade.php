@extends('layout')

@section('title', 'Mi Perfil - BeStrong')

@section('content')

<div class="max-w-3xl mx-auto mt-12 px-4">

    <div class="text-center mb-12 relative">
        <div class="flex justify-center mb-8">
            <div class="rounded-full overflow-hidden border-4 border-red-500 shadow-xl" style="width: 100px; height: 100px; flex-shrink: 0;">
                <img 
                    src="{{ $datosUsuario->imagen 
                        ? asset('storage/' . $datosUsuario->imagen) 
                        : 'https://ui-avatars.com/api/?name=' . urlencode($datosUsuario->nombre . ' ' . $datosUsuario->apellido) }}"
                    style="width: 100%; height: 100%; object-fit: cover; display: block;"
                >
            </div>
        </div>

        <h1 class="text-5xl font-black text-red-600 tracking-tight">
            Mi Perfil
        </h1>

        <p class="text-gray-500 mt-2 text-sm">
            Información personal del usuario
        </p>

        <p class="text-gray-500 mt-1 text-sm">
            <a href="{{ route('datos_usuarios.update', $datosUsuario->id) }}"
               class="text-red-500 hover:text-red-700 font-medium transition">
                Editar perfil
            </a>
        </p>

    </div>

    <div class="bg-white rounded-3xl shadow-xl overflow-hidden">

        <div class="h-2 bg-gradient-to-r from-red-500 to-orange-500"></div>

        <div class="p-10">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="bg-gray-50 rounded-2xl p-5 hover:shadow-md transition">
                    <p class="text-xs text-gray-500 uppercase">Nombre</p>
                    <p class="text-lg font-bold text-gray-900 mt-1">
                        {{ $datosUsuario->nombre }}
                    </p>
                </div>

                <div class="bg-gray-50 rounded-2xl p-5 hover:shadow-md transition">
                    <p class="text-xs text-gray-500 uppercase">Apellido</p>
                    <p class="text-lg font-bold text-gray-900 mt-1">
                        {{ $datosUsuario->apellido }}
                    </p>
                </div>

                <div class="bg-gray-50 rounded-2xl p-5 hover:shadow-md transition">
                    <p class="text-xs text-gray-500 uppercase">Sexo</p>
                    <p class="text-lg font-bold text-gray-900 mt-1">
                        {{ $datosUsuario->sexo }}
                    </p>
                </div>

                <div class="bg-gray-50 rounded-2xl p-5 hover:shadow-md transition">
                    <p class="text-xs text-gray-500 uppercase">Fecha nacimiento</p>
                    <p class="text-lg font-bold text-gray-900 mt-1">
                        {{ $datosUsuario->fecha_nacimiento }}
                    </p>
                </div>

                <div class="bg-gray-50 rounded-2xl p-5 hover:shadow-md transition">
                    <p class="text-xs text-gray-500 uppercase">Altura</p>
                    <p class="text-lg font-bold text-gray-900 mt-1">
                        {{ $datosUsuario->altura }} cm
                    </p>
                </div>

                <div class="bg-gray-50 rounded-2xl p-5 hover:shadow-md transition">
                    <p class="text-xs text-gray-500 uppercase">Peso</p>
                    <p class="text-lg font-bold text-gray-900 mt-1">
                        {{ $datosUsuario->peso }} kg
                    </p>
                </div>

            </div>

        </div>
    </div>

</div>

@endsection