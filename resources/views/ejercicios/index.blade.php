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

    #tablaEjercicios caption {
        color: var(--text-muted);
        margin-bottom: 15px;
        font-size: 0.9rem;
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
        transition: transform 0.2s, box-shadow 0.2s;
    }

    tbody tr:hover {
        transform: scale(1.01);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.4);
    }

    tbody td:first-child { border-radius: 12px 0 0 12px; }
    tbody td:last-child  { border-radius: 0 12px 12px 0; }

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
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .ejercicio-img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 8px;
        background-color: #334155;
        border: 2px solid #334155;
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
        font-size: 0.8rem;
    }
</style>

<div class="container-tabla">

    <h1>Lista de Ejercicios</h1>

    <div class="flex justify-center mb-8">
        <form method="GET" action="{{ route('ejercicios.index') }}" class="w-full max-w-md flex gap-2">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Buscar ejercicio..."
                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm"
            >
            <button type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-3 rounded-xl font-semibold transition">
                Buscar
            </button>
            @if(request('search'))
                <a href="{{ route('ejercicios.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-3 rounded-xl font-semibold transition">
                    ✕
                </a>
            @endif
        </form>
    </div>

    <table id="tablaEjercicios">
        <caption>
            Ejercicios disponibles en la base de datos: {{ $total_ejercicios }}
            @if(request('search'))
                · Resultados para <strong>"{{ request('search') }}"</strong>
            @endif
        </caption>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Imagen</th>
                <th>Detalles</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ejercicios as $ejercicio)
                <tr>
                    <td>
                        <span class="ejercicio-nombre">{{ $ejercicio->nombre }}</span>
                    </td>
                    <td>
                        <div class="ejercicio-desc">
                            {!! $ejercicio->descripcion ?? 'Sin descripción detallada.' !!}
                        </div>
                    </td>
                    <td>
                        @if($ejercicio->imagen)
                            <img src="{{ $ejercicio->imagen }}"
                                 class="ejercicio-img"
                                 alt="{{ $ejercicio->nombre }}">
                        @else
                            <div class="no-img">Sin Imagen</div>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('ejercicios.show', $ejercicio->id) }}"
                           class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg transition duration-300">
                            Ver Detalles
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-10 text-gray-400">
                        No se encontraron ejercicios
                        @if(request('search'))
                            para <strong>"{{ request('search') }}"</strong>
                        @endif
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