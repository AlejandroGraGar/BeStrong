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

    h1 {
        text-align: center;
        font-size: 2.5rem;
        font-weight: 800;
        margin: 40px 0;
        text-transform: uppercase;
        letter-spacing: -1px;
        color: var(--primary);
    }

    .container-tabla {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    #tablaEjercicios {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 12px;
        margin-bottom: 50px;
    }

    thead th {
        background-color: transparent;
        color: var(--text-muted);
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.1em;
        padding: 10px 20px;
        text-align: left;
    }

    tbody tr {
        background-color: rgb(75, 85, 99);
        transition: 0.2s;
    }

    tbody tr:hover {
        transform: scale(1.01);
    }

    tbody td:first-child { border-radius: 12px 0 0 12px; }
    tbody td:last-child { border-radius: 0 12px 12px 0; }

    td {
        padding: 20px;
        vertical-align: middle;
    }

    .ejercicio-nombre {
        font-weight: 700;
        font-size: 1.1rem;
        color: var(--text-main);
    }

    .ejercicio-desc {
        font-size: 0.9rem;
        color: var(--text-muted);
        max-width: 500px;
        line-height: 1.6;
        overflow: hidden;
    }

    .ejercicio-img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 8px;
    }

    .no-img {
        width: 120px;
        height: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #334155;
        border-radius: 8px;
        color: #64748b;
    }

    .btn {
        padding: 6px 10px;
        border-radius: 8px;
        font-weight: 600;
        display: inline-block;
    }

    .btn-edit {
        background: #3b82f6;
        color: white;
    }

    .btn-delete {
        background: #ef4444;
        color: white;
        border: none;
        cursor: pointer;
    }

    .btn-new {
        background: #fbbf24;
        color: #111;
        font-weight: 800;
        padding: 10px 14px;
        border-radius: 10px;
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
                <a href="{{ route('ejercicios.create') }}" class="btn btn-primary">
                    Nuevo
                </a>
            @endif
        </form>
    </div>

    <table id="tablaEjercicios">
        <caption>
            Ejercicios: {{ $total_ejercicios }}
            @if(request('search'))
                · "{{ request('search') }}"
            @endif
        </caption>

        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @forelse($ejercicios as $ejercicio)
                <tr>
                    <td class="ejercicio-nombre">{{ $ejercicio->nombre }}</td>

                    <td class="ejercicio-desc">
                        {!! $ejercicio->descripcion ?? 'Sin descripción' !!}
                    </td>

                    <td>
                        @if($ejercicio->imagen)
                            <img src="{{ $ejercicio->imagen }}" class="ejercicio-img">
                        @else
                            <div class="no-img">Sin imagen</div>
                        @endif
                    </td>

                    <td>
                        <a href="{{ route('ejercicios.show', $ejercicio) }}" class="btn bg-gray-700 text-white">
                            Ver
                        </a>

                        @if(auth()->user()->is_admin)
                            <a href="{{ route('ejercicios.edit', $ejercicio) }}" class="btn btn-edit">
                                Editar
                            </a>

                            <form action="{{ route('ejercicios.destroy', $ejercicio) }}"
                                  method="POST"
                                  style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-delete"
                                        onclick="return confirm('¿Eliminar ejercicio?')">
                                    Borrar
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-gray-400">
                        No se encontraron ejercicios
                    </td>
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

@endsection