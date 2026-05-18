@extends('layout')

@section('title', 'Progreso - BeStrong')

@section('content')

<div class="max-w-5xl mx-auto mt-10">

    <div class="bg-white rounded-3xl shadow-lg overflow-hidden">

        <div class="bg-red-500 px-8 py-6">

            <h1 class="text-3xl font-black text-gray-600">
                Progreso del ejercicio
            </h1>

            <p class="text-red-100 mt-1">
                Evolución de pesos del usuario
            </p>

        </div>

        <div class="p-8">

            <div class="mb-8">

                <h2 class="text-2xl font-black text-gray-800">
                    {{ $ejercicio->nombre }}
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Seguimiento del peso máximo por entrenamiento
                </p>

            </div>

            <div class="bg-gray-50 rounded-3xl p-6">

                <canvas id="graficaProgreso" height="120"></canvas>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('graficaProgreso');

new Chart(ctx, {
    type: 'line',

    data: {
        labels: @json($labels),

        datasets: [{
            label: 'Peso máximo (kg)',

            data: @json($data),

            borderWidth: 3,

            tension: 0.35,

            fill: true
        }]
    },

    options: {

        responsive: true,

        plugins: {
            legend: {
                display: true
            }
        },

        scales: {
            y: {
                beginAtZero: true
            }
        }

    }
});
</script>

@endsection