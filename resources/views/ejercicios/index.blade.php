@extends('layout')

@section('title', 'Ejercicios')

@section('content')

<style>
    :root {
        --primary: #fbbf24;
        --accent: #3b82f6;
        --bg: #0f172a;
        --card-bg: #1e293b;
        --text-main: #f8fafc;
        --text-muted: #94a3b8;
    }

    .container-tabla {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .container-tabla h1 {
        text-align: center;
        font-size: 2.5rem;
        font-weight: 800;
        margin: 40px 0;
        text-transform: uppercase;
        letter-spacing: -1px;
        color: var(--primary);
    }

    .container-tabla #tablaEjercicios {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 12px;
        margin-bottom: 50px;
        table-layout: fixed;
    }

    .container-tabla thead th:nth-child(1) { width: 20%; }
    .container-tabla thead th:nth-child(2) { width: 45%; }
    .container-tabla thead th:nth-child(3) { width: 15%; }
    .container-tabla thead th:nth-child(4) { width: 20%; }

    .container-tabla thead th {
        background-color: transparent;
        color: var(--text-muted);
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.1em;
        padding: 10px 20px;
        text-align: left;
    }

    .container-tabla tbody tr {
        background-color: rgb(75, 85, 99);
        transition: 0.2s;
    }

    .container-tabla tbody tr:hover {
        transform: scale(1.01);
    }

    .container-tabla tbody td:first-child { border-radius: 12px 0 0 12px; }
    .container-tabla tbody td:last-child { border-radius: 0 12px 12px 0; }

    .container-tabla td {
        padding: 20px;
        vertical-align: middle;
    }

    .container-tabla .ejercicio-nombre {
        font-weight: 700;
        font-size: 1rem;
        color: var(--text-main);
        word-wrap: break-word;
    }

    .container-tabla .ejercicio-desc {
        font-size: 0.9rem;
        color: var(--text-muted);
        line-height: 1.6;
    }

    .container-tabla .desc-content {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .container-tabla .desc-content.expanded {
        display: block;
        -webkit-line-clamp: unset;
    }

    .container-tabla .ver-mas {
        color: var(--accent);
        cursor: pointer;
        font-size: 0.85rem;
        font-weight: 600;
        margin-top: 4px;
        display: inline-block;
        user-select: none;
    }

    .container-tabla .ejercicio-img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 12px;
    }

    .container-tabla .no-img {
        width: 150px;
        height: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #334155;
        border-radius: 12px;
        color: #64748b;
    }

    .container-tabla .btn {
        padding: 6px 10px;
        border-radius: 8px;
        font-weight: 600;
        display: inline-block;
        margin-top: 5px;
    }

    .container-tabla .btn-edit {
        background: #3b82f6;
        color: white;
    }

    .container-tabla .btn-delete {
        background: #ef4444;
        color: white;
        border: none;
        cursor: pointer;
    }
</style>

<div class="container-tabla">

    <h1>Lista de Ejercicios</h1>

    <div class="flex justify-center mb-8">
        <form method="GET" action="{{ route('ejercicios.index') }}" class="w-full max-w-md flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Buscar ejercicio..."
                   class="w-full px-4 py-3 rounded-xl border">

            <button type="submit" class="bg-blue-500 text-white px-5 py-3 rounded-xl">
                Buscar
            </button>

            @if(request('search'))
                <a href="{{ route('ejercicios.index') }}" class="bg-gray-500 text-white px-4 py-3 rounded-xl">✕</a>
            @endif

            @if(auth()->user()->is_admin)
                <a href="{{ route('ejercicios.create') }}" class="btn btn-primary" style="padding: 12px 14px;">Nuevo</a>
            @endif
        </form>
    </div>

    <table id="tablaEjercicios">
        <caption>
            Ejercicios: {{ $total_ejercicios }}
            @if(request('search')) · "{{ request('search') }}" @endif
        </caption>

        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Imagen</th>
                <th>Progreso</th>
            </tr>
        </thead>

        <tbody>
            @forelse($ejercicios as $ejercicio)
                <tr>
                    <td class="ejercicio-nombre fs-3">{{ $ejercicio->nombre }}</td>

                    <td class="ejercicio-desc">
                        <div class="desc-content" id="desc-{{ $ejercicio->id }}">
                            {!! $ejercicio->descripcion ?? 'Sin descripción' !!}
                        </div>
                        <span class="ver-mas" onclick="toggleDesc({{ $ejercicio->id }})" id="toggle-{{ $ejercicio->id }}">
                            Ver más
                        </span>
                    </td>

                    <td>
                        @if($ejercicio->imagen)
                            <img src="{{ $ejercicio->imagen }}" class="ejercicio-img">
                        @else
                            <div class="no-img">Sin imagen</div>
                        @endif
                    </td>

                    <td>
                        <a href="{{ route('ejercicios.show', $ejercicio) }}" class="btn bg-gray-700 text-white">Ver</a>
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('ejercicios.edit', $ejercicio) }}" class="btn btn-edit">Editar</a>
                            <form action="{{ route('ejercicios.destroy', $ejercicio) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button class="btn btn-delete" onclick="return confirm('¿Eliminar?')">Borrar</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-gray-400">No se encontraron ejercicios</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($ejercicios->hasPages())
        <div class="flex justify-center mb-10">
            {{ $ejercicios->links() }}
        </div>
    @endif
</div>

<script>
function toggleDesc(id) {
    const content = document.getElementById('desc-' + id);
    const toggle = document.getElementById('toggle-' + id);
    content.classList.toggle('expanded');
    toggle.textContent = content.classList.contains('expanded') ? 'Ver menos' : 'Ver más';
}
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.desc-content').forEach(el => {
        if (el.scrollHeight <= el.clientHeight) {
            const toggle = el.nextElementSibling;
            if (toggle) toggle.style.display = 'none';
        }
    });
});
</script>

@endsection