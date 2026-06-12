@extends('layout')

@section('title', 'Crear Ejercicio')

@section('content')

<style>
    :root {
        --primary: #fbbf24;
        --accent: #3b82f6;
        --text-main: #f8fafc;
        --text-muted: #94a3b8;
    }

    .create-container {
        max-width: 600px;
        margin: 60px auto;
        padding: 0 20px;
    }

    h1 {
        font-size: 2rem;
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 32px;
    }

    .card {
        background: #30363f;
        border-radius: 16px;
        padding: 32px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-size: 0.8rem;
        color: var(--text-muted);
        text-transform: uppercase;
        margin-bottom: 6px;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        background: #172036;
        border: 1px solid #334155;
        border-radius: 8px;
        padding: 10px 14px;
        color: var(--text-main);
        outline: none;
    }

    .form-group textarea {
        min-height: 120px;
        resize: vertical;
    }

    .img-preview {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 8px;
        margin-top: 10px;
        border: 2px solid #495363;
        display: none;
    }
</style>

<div class="create-container">

    <h2>➕ Crear Ejercicio</h2>
    <br>

    <div class="card">

        <form method="POST" action="{{ route('ejercicios.store') }}">
            @csrf

            <div class="form-group">
                <label>Nombre *</label>
                <input type="text" name="nombre" value="{{ old('nombre') }}" required>
                @error('nombre')
                    <p class="text-red-400 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label>Descripción</label>
                <textarea name="descripcion">{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <p class="text-red-400 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label>Imagen (URL)</label>
                <input type="text" id="imagen" name="imagen"
                       value="{{ old('imagen') }}"
                       placeholder="https://..."
                       oninput="previewImg(this.value)">

                <img id="imgPreview" class="img-preview">

                @error('imagen')
                    <p class="text-red-400 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between items-center mt-6">
                <a href="{{ route('ejercicios.index') }}"
                   class="text-gray-400 hover:text-white font-semibold">
                    ← Volver
                </a>

                <button type="submit" class="bg-yellow-400 hover:bg-yellow-500 text-white px-6 py-2 rounded-lg font-bold">
                    Crear
                </button>
            </div>

        </form>

    </div>
</div>

<script>
function previewImg(url) {
    const img = document.getElementById('imgPreview');

    if (url) {
        img.src = url;
        img.style.display = 'block';
    } else {
        img.style.display = 'none';
    }
}
</script>

@endsection