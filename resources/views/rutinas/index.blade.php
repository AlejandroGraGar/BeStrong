@extends('layout')

@section('title', 'Rutinas - BeStrong')

@section('content')

<div class="max-w-5xl mx-auto mt-10">

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-black text-red-600">Mis Rutinas</h1>
            <p class="text-gray-500 mt-1">Organiza y gestiona tus rutinas de entrenamiento</p>
        </div>
        
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($rutinas as $rutina)
        <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl hover:-translate-y-1 overflow-hidden transition-all duration-300">
            <div class=" h-2"></div>
                <div class="p-6">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14  rounded-2xl flex items-center justify-center">
                                <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-gray-900">{{ $rutina->nombre }}</h2>
                                <p class="text-sm text-gray-400">{{ $rutina->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                    
                    @if($rutina->descripcion)
                        <p class="text-gray-600 mt-4 text-sm line-clamp-2">{{ $rutina->descripcion }}</p>
                    @endif

                    <div class="flex items-center gap-3 mt-6 pt-4 border-t border-gray-100">
                        <a href="{{ route('rutinas.show', $rutina) }}" class=" btn bg-gray-100 0 text-gray-700 font-semibold py-2.5 px-4 text-center text-sm transition-colors border border-gray-300 hover:bg-gray-200">
                            Ver Detalles
                        </a>
                        <a href="{{ route('ejercicioRutina.update', $rutina) }}" class="p-2.5 btn bg-blue-50 0 text-blue-600 rounded-xl transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        <form action="{{ route('rutinas.destroy', $rutina) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta rutina?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2.5  text-red-600 rounded-xl transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                        
                            <a href="{{ route('entrenamientos.start.rutina', $rutina->id) }}" class="btn">Empezar rutina</a>
                        

                            
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-2 text-center py-20 bg-white rounded-2xl shadow-lg">
                    <div class="w-24 h-24  rounded-3xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
                <p class="text-gray-700 font-bold text-xl">No tienes rutinas creadas</p>
                <p class="text-gray-400 mt-2">Crea tu primera rutina para comenzar</p>
                
             
            </div>
            @endforelse

            <a href="{{ route('rutinas.create') }}" class="inline-block mt-6   text-gray-600 font-bold py-3 px-6 rounded-xl shadow-lg">
                Crear Rutina
            </a>
        </div>

</div>
@endsection