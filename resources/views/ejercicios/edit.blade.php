@extends('layout')

@section('title', 'Editar Ejercicio')

@section('content')

<style>
    :root {
        --primary: #fbbf24;
        --accent: #3b82f6;
        --text-main: #f8fafc;
        --text-muted: #94a3b8;
    }

    .edit-container {
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
        background: #1e293b;
        border-radius: 16px;
        padding: 32px;
    }

    .form-group { margin-bottom: 20px; }

    .form-group label {
        display: block;
        font-size: 0.8rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 6px;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        background: #0f172a;
        border: 1px solid #334155;
        border-radius: 8px;
        padding: 10px 14px;
        color: var(--text-main);
        font-size: 0.95rem;
        outline: none;
        transition: border-color 0.2s;
        box-sizing: border-box;
    }

    .form-group input:focus,
    .form-group textarea:focus { border-color: var(--accent); }
    .form-group textarea { resize: vertical; min-height: 140px; }

    .img-preview {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        margin-top: 8px;
        border: 2px solid #334155;
    }
</style>

<div class="edit-container">
    <h2>Editar Ejercicio</h2>
    <br>
    <div class="card">
        <form method="POST" action="{{ route('ejercicios.update', $ejercicio->id) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nombre">Nombre *</label>
                <input type="text" id="nombre" name="nombre"
                       value="{{ old('nombre', $ejercicio->nombre) }}" required>
                @error('nombre')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion">{{ old('descripcion', $ejercicio->descripcion) }}</textarea>
                @error('descripcion')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="imagen">URL de imagen</label>
                <input type="url" id="imagen" name="imagen"
                       value="{{ old('imagen', $ejercicio->imagen) }}"
                       placeholder="https://..."
                       oninput="previewImg(this.value)">
                @if($ejercicio->imagen)
                    <img id="imgPreview" src="{{ $ejercicio->imagen }}" class="img-preview">
                @else
                    <img id="imgPreview" src="" class="img-preview" style="display:none">
                @endif
                @error('imagen')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between items-center mt-6">
                <a href="{{ route('ejercicios.index') }}"
                   class="text-gray-400 hover:text-white transition font-semibold">
                    ← Volver
                </a>
                <button type="submit" class="bg-yellow-400 hover:bg-yellow-500 text-white px-6 py-2 rounded-lg font-bold transition">
                    Guardar cambios
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