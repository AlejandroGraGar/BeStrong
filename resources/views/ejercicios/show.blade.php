@extends('layout')

@section('title', 'Progreso - BeStrong')

@section('content')

<div class="max-w-5xl mx-auto mt-10 px-4">

    <div class="bg-white rounded-3xl shadow-lg overflow-hidden">

        <div class="bg-red-500 px-8 py-6">
            <h1 class="text-3xl font-black text-white">
                Progreso del ejercicio
            </h1>
            <p class="text-red-100 mt-1">
                Evolución de pesos del usuario
            </p>
        </div>

        <div class="p-8">

            <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                <div>
                    <h2 class="text-2xl font-black text-gray-800">
                        {{ $ejercicio->nombre }}
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Peso máximo registrado por sesión
                    </p>
                </div>

                @if(count($data) > 0)
                <div class="flex gap-4">
                    <div class="bg-red-50 rounded-2xl px-5 py-3 text-center">
                        <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Máximo</p>
                        <p class="text-2xl font-black text-red-500">{{ max($data->toArray()) }} <span class="text-sm font-semibold">kg</span></p>
                    </div>
                    <div class="bg-gray-50 rounded-2xl px-5 py-3 text-center">
                        <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Sesiones</p>
                        <p class="text-2xl font-black text-gray-700">{{ count($data) }}</p>
                    </div>
                </div>
                @endif

            </div>

            @if(count($data) > 0)
                <div class="bg-gray-50 rounded-3xl p-6">
                    <canvas id="graficaProgreso" height="100"></canvas>
                </div>
            @else
                <div class="bg-gray-50 rounded-3xl p-12 text-center">
                    <div class="text-5xl mb-4">📊</div>
                    <p class="text-gray-500 font-semibold text-lg">Aún no hay datos de progreso</p>
                    <p class="text-gray-400 text-sm mt-1">Completa entrenamientos con este ejercicio para ver tu evolución</p>
                </div>
            @endif

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@if(count($data) > 0)
<script>
const ctx = document.getElementById('graficaProgreso').getContext('2d');

const gradient = ctx.createLinearGradient(0, 0, 0, 400);
gradient.addColorStop(0, 'rgba(239, 68, 68, 0.3)');
gradient.addColorStop(1, 'rgba(239, 68, 68, 0.0)');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: @json($labels),
        datasets: [{
            label: 'Peso máximo (kg)',
            data: @json($data),
            borderColor: '#ef4444',
            backgroundColor: gradient,
            borderWidth: 3,
            tension: 0.4,
            fill: true,
            pointBackgroundColor: '#ef4444',
            pointBorderColor: '#ffffff',
            pointBorderWidth: 2,
            pointRadius: 6,
            pointHoverRadius: 8,
            pointHoverBackgroundColor: '#ef4444',
            pointHoverBorderColor: '#ffffff',
            pointHoverBorderWidth: 3,
        }]
    },
    options: {
        responsive: true,
        interaction: {
            intersect: false,
            mode: 'index',
        },
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: '#1f2937',
                titleColor: '#f9fafb',
                bodyColor: '#ef4444',
                padding: 12,
                cornerRadius: 12,
                displayColors: false,
                callbacks: {
                    title: (items) => '📅 ' + items[0].label,
                    label: (item) => '🏋️ ' + item.raw + ' kg',
                }
            }
        },
        scales: {
            x: {
                grid: {
                    display: false,
                },
                ticks: {
                    color: '#9ca3af',
                    font: { size: 12 },
                    maxRotation: 45,
                }
            },
            y: {
                beginAtZero: false,
                grid: {
                    color: 'rgba(0,0,0,0.05)',
                },
                ticks: {
                    color: '#9ca3af',
                    font: { size: 12 },
                    callback: (value) => value + ' kg'
                }
            }
        }
    }
});
</script>
@endif

@endsection