@extends('layout')

@section('title', 'Mis Entrenamientos - BeStrong')

@section('content')
<div class="flex flex-col lg:flex-row gap-8 items-start mt-10">
    
    <div class="flex-grow-[2] bg-white rounded-3xl p-8 shadow-lg" style="flex-basis: 66%;">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-black text-red-600">Mis Entrenamientos</h1>
                <p class="text-sm text-gray-500 mt-1">Gestiona tus rutinas de ejercicio</p>
            </div>
            
            <a href="{{ route('entrenamientosEjercicio.create') }}" class="bg-red-500 hover:bg-red-600 text-black font-bold py-3 px-6 rounded-2xl text-sm shadow-lg">
                + Nuevo Entrenamiento
            </a>
        </div>

        <div class="space-y-4">
            @forelse($entrenamientos as $entrenamiento)
                <div class="bg-gray-50 hover:bg-red-50 border border-gray-200 rounded-2xl p-5 cursor-pointer">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 bg-red-500 rounded-2xl flex items-center justify-center">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900 text-lg">{{ auth()->user()->name }}</p>
                                <p class="text-sm text-gray-500">Nombre rutina</p>
                            </div>
                        </div>
                        <span class="px-4 py-1.5 bg-green-500 text-white text-xs font-bold rounded-full">Activo</span>
                    </div>
                </div>
            @empty
                <div class="text-center py-24 bg-red-50 rounded-2xl border-2 border-dashed border-red-300">
                    <div class="w-24 h-24 bg-red-500 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    </div>
                    <p class="text-gray-700 font-bold text-xl">No hay entrenamientos registrados</p>
                    <p class="text-gray-400 mt-2">Crea tu primer entrenamiento para comenzar</p>
                </div>
            @endforelse
        </div>
    </div>

    <div class="flex-grow" style="flex-basis: 33%;">
        <div class="bg-white rounded-3xl shadow-lg overflow-hidden">
            <div class="bg-red-500 h-28 relative">
                <div class="absolute -bottom-14 left-1/2 -translate-x-1/2">
                    <div class="w-28 h-28 bg-white rounded-3xl p-1.5 shadow-xl">
                        <div class="w-full h-full bg-red-500 rounded-2xl flex items-center justify-center">
                            <svg class="w-14 h-14 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="pt-20 pb-8 px-6 text-center">
                <h2 class="text-2xl font-black text-gray-900">{{ auth()->user()->name }}</h2>
                <p class="text-sm text-gray-500 mt-1">@bestrong_user</p>
                
                <div class="grid grid-cols-3 gap-3 mt-8 pt-6 border-t border-gray-200">
                    <div class="bg-red-50 rounded-2xl py-4">
                        <span class="block text-3xl font-black text-red-500">11</span>
                        <span class="text-xs text-gray-600 font-bold">Entrenos</span>
                    </div>
                    <div class="bg-red-50 rounded-2xl py-4">
                        <span class="block text-3xl font-black text-red-500">21</span>
                        <span class="text-xs text-gray-600 font-bold">Seguidores</span>
                    </div>
                    <div class="bg-red-50 rounded-2xl py-4">
                        <span class="block text-3xl font-black text-red-500">21</span>
                        <span class="text-xs text-gray-600 font-bold">Seguidos</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection