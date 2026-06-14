@extends('layout')

@section('title', 'Mi Perfil - BeStrong')

@section('content')

<div class="max-w-3xl mx-auto mt-12 px-4">
<a href="{{ route('datos_usuarios.index') }}"
                   class="inline-flex items-center gap-2 text-gray-600 hover:text-red-500 font-medium">
                    ← Volver
                </a>
    <div class="text-center mb-12">
        <h1 class="text-5xl font-black text-red-600 tracking-tight">
            Mi Perfil
        </h1>

        <p class="text-gray-500 mt-2 text-sm">
            Información personal del usuario
        </p>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('datos_usuarios.update', $datosUsuario->id) }}" method="POST" enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">

            <div class="h-2 bg-gradient-to-r from-red-500 to-orange-500"></div>

            <div class="p-10">

                <div class="flex flex-col items-center mb-8">

                    <div class="rounded-full overflow-hidden border-4 border-red-400 shadow-lg" style="width: 100px; height: 100px; flex-shrink: 0;">
                        <img id="previewImagen" src="{{ $datosUsuario->imagen ? asset('storage/' . $datosUsuario->imagen) : 'https://ui-avatars.com/api/?name=' . $datosUsuario->nombre }}"
                             style="width: 100%; height: 100%; object-fit: cover; display: block;">
                    </div>

                    <label class="mt-4 cursor-pointer bg-red-500 hover:bg-red-600 text-white font-bold px-4 py-2 rounded-xl shadow transition">
                        Cambiar foto
                        <input type="file" name="imagen" accept="image/*" class="hidden" onchange="previewImage(event)">
                    </label>

                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div class="bg-gray-50 rounded-2xl p-5">
                        <p class="text-xs text-gray-500 uppercase">Nombre</p>
                        <input type="text" name="nombre" value="{{ old('nombre', $datosUsuario->nombre) }}" class="w-full text-lg font-bold text-gray-900 mt-1 bg-transparent outline-none">
                    </div>

                    <div class="bg-gray-50 rounded-2xl p-5">
                        <p class="text-xs text-gray-500 uppercase">Apellido</p>
                        <input type="text" name="apellido" value="{{ old('apellido', $datosUsuario->apellido) }}" class="w-full text-lg font-bold text-gray-900 mt-1 bg-transparent outline-none">
                    </div>

                    <div class="bg-gray-50 rounded-2xl p-5">
                        <p class="text-xs text-gray-500 uppercase">Sexo</p>
                        <select name="sexo"
                                class="w-full mt-2 rounded-xl border border-gray-300 px-4 py-2 text-lg font-bold text-gray-900 focus:ring-2 focus:ring-red-200 outline-none">

                            <option value="Masculino" {{ old('sexo', $datosUsuario->sexo) == 'Masculino' ? 'selected' : '' }}>
                                Masculino
                            </option>

                            <option value="Femenino" {{ old('sexo', $datosUsuario->sexo) == 'Femenino' ? 'selected' : '' }}>
                                Femenino
                            </option>

                            <option value="Otro" {{ old('sexo', $datosUsuario->sexo) == 'Otro' ? 'selected' : '' }}>
                                Otro
                            </option>

                        </select>
                    </div>

                    <div class="bg-gray-50 rounded-2xl p-5">
                        <p class="text-xs text-gray-500 uppercase">Fecha nacimiento</p>
                        <input type="date" name="fecha_nacimiento"
                               value="{{ old('fecha_nacimiento', $datosUsuario->fecha_nacimiento) }}"
                               class="w-full text-lg font-bold text-gray-900 mt-1 bg-transparent outline-none">
                    </div>

                    <div class="bg-gray-50 rounded-2xl p-5">
                        <p class="text-xs text-gray-500 uppercase">Altura (cm)</p>
                        <input type="number" name="altura"
                               value="{{ old('altura', $datosUsuario->altura) }}"
                               class="w-full text-lg font-bold text-gray-900 mt-1 bg-transparent outline-none">
                    </div>

                    <div class="bg-gray-50 rounded-2xl p-5">
                        <p class="text-xs text-gray-500 uppercase">Peso (kg)</p>
                        <input type="number" name="peso"
                               value="{{ old('peso', $datosUsuario->peso) }}"
                               class="w-full text-lg font-bold text-gray-900 mt-1 bg-transparent outline-none">
                    </div>

                </div>

                <div class="mt-10">
                    <button type="submit"
                            class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-4 rounded-2xl shadow-lg transition">
                        Guardar cambios
                    </button>
                </div>

            </div>
        </div>
    </form>

</div>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function () {
        document.getElementById('previewImagen').src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>

@endsection