@extends('layout')

@section('title', 'Completar Perfil - BeStrong')

@section('content')

<div class="max-w-xl mx-auto mt-12 px-4">

    <div class="mb-10 text-center">
        <h1 class="text-4xl font-black text-red-600 tracking-tight">
            Completa tu perfil
        </h1>

        <p class="text-gray-500 mt-2 text-sm">
            Añade tus datos para personalizar tu experiencia de entrenamiento
        </p>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 text-green-700 px-5 py-3 rounded-2xl">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 bg-red-50 text-red-700 px-5 py-3 rounded-2xl">
            <ul class="list-disc list-inside space-y-1 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-lg overflow-hidden">

        <div class="h-2 bg-gradient-to-r from-red-500 to-red-700"></div>

        <div class="p-8 md:p-10">

            <form action="{{ route('datos_usuario.create' ) }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nombre</label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}"
                        class="w-full bg-gray-50 rounded-2xl px-4 py-3
                        focus:bg-white focus:ring-2 focus:ring-red-200 outline-none transition"
                        required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Apellido</label>
                    <input type="text" name="apellido" value="{{ old('apellido') }}"
                        class="w-full bg-gray-50 rounded-2xl px-4 py-3
                        focus:bg-white focus:ring-2 focus:ring-red-200 outline-none transition"
                        required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Sexo</label>
                    <select name="sexo"
                        class="w-full bg-gray-50 rounded-2xl px-4 py-3
                        focus:bg-white focus:ring-2 focus:ring-red-200 outline-none transition"
                        required>
                        <option value="">Selecciona una opción</option>
                        <option value="Hombre">Hombre</option>
                        <option value="Mujer">Mujer</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Fecha de nacimiento</label>
                    <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}"
                        class="w-full bg-gray-50 rounded-2xl px-4 py-3
                        focus:bg-white focus:ring-2 focus:ring-red-200 outline-none transition"
                        required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Altura (cm)</label>
                    <input type="number" name="altura" value="{{ old('altura') }}" placeholder="Ej: 180"
                        class="w-full bg-gray-50 rounded-2xl px-4 py-3
                        focus:bg-white focus:ring-2 focus:ring-red-200 outline-none transition"
                        required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Peso (kg)</label>
                    <input type="number" name="peso" value="{{ old('peso') }}" placeholder="Ej: 75"
                        class="w-full bg-gray-50 rounded-2xl px-4 py-3
                        focus:bg-white focus:ring-2 focus:ring-red-200 outline-none transition"
                        required>
                </div>

                <button type="submit"
                    class="w-full py-4 rounded-2xl text-black font-bold text-lg
                    bg-gradient-to-r from-red-500 to-red-600
                    hover:from-red-600 hover:to-red-700
                    shadow-md hover:shadow-lg transition">
                    Guardar perfil
                </button>

            </form>

        </div>
    </div>

</div>

@endsection