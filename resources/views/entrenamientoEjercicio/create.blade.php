@extends('layout')

@section('title', 'Entreno')

@section('content')

<style>
body {
    background-color: #f5f6fa;
}

.main-container {
    max-width: 900px;
    margin: auto;
}

.card-light {
    background-color: white;
    border-radius: 15px;
    border: 1px solid #e0e0e0;
}

.input-light {
    background-color: #f1f3f5;
    border: 1px solid #ddd;
    color: black;
    border-radius: 10px;
    height: 40px;
}

.timer-box {
    background-color: white;
    padding: 6px 12px;
    border-radius: 10px;
    border: 1px solid #ddd;
    font-weight: bold;
}

.delete-serie {
    cursor: pointer;
    color: red;
    font-weight: bold;
    margin-left: 5px;
}
</style>

<div class="container py-3 main-container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold">Entreno</h5>
        <div class="timer-box">
            <span id="timer">00:00</span>
        </div>
    </div>

    <form action="{{ route('entrenamientosEjercicio.create') }}" method="POST">
        @csrf

        <input type="hidden" name="duracion" id="duracionInput">
        <input type="hidden" name="entrenamiento_id" value="{{ $entrenamiento_id }}">

        <div id="ejerciciosContainer"></div>

        <div class="card-light p-3 mb-3">
            <select id="ejercicioSelect" class="form-control input-light mb-2">
                <option value="">Selecciona ejercicio</option>
                @foreach($ejercicios as $ejercicio)
                    <option value="{{ $ejercicio->id }}">{{ $ejercicio->nombre }}</option>
                @endforeach
            </select>

            <button type="button" id="addEjercicioBtn" class="btn btn-primary w-100">
                + Añadir ejercicio
            </button>
        </div>

        <button type="submit" class="btn btn-success w-100">
            Guardar Entreno
        </button>
    </form>
</div>

<script>
let ejercicioCount = 0;

document.getElementById('addEjercicioBtn').addEventListener('click', function() {
    const select = document.getElementById('ejercicioSelect');
    const id = select.value;
    const nombre = select.options[select.selectedIndex].text;

    if (!id) return;

    ejercicioCount++;

    const container = document.getElementById('ejerciciosContainer');

    const ejercicioDiv = document.createElement('div');
    ejercicioDiv.classList.add('card-light', 'p-3', 'mb-3');

    ejercicioDiv.innerHTML = `
        <div class="d-flex justify-content-between mb-2">
            <strong>${nombre}</strong>
            <button type="button" class="btn btn-sm btn-danger deleteEjercicio">✕</button>
        </div>

        <input type="hidden" name="ejercicios[${ejercicioCount}][id]" value="${id}">

        <div class="seriesContainer"></div>

        <button type="button" class="btn btn-outline-secondary w-100 mt-2 addSerieBtn">
            + Añadir serie
        </button>
    `;

    container.appendChild(ejercicioDiv);

    ejercicioDiv.querySelector('.deleteEjercicio').addEventListener('click', function() {
        ejercicioDiv.remove();
    });

    const addSerieBtn = ejercicioDiv.querySelector('.addSerieBtn');

    addSerieBtn.addEventListener('click', function() {
        const seriesContainer = ejercicioDiv.querySelector('.seriesContainer');
        const index = seriesContainer.children.length + 1;

        const serie = document.createElement('div');
        serie.classList.add('d-flex', 'align-items-center', 'mb-2');

        serie.innerHTML = `
            <div style="width:25px">${index}</div>

            <input type="number" placeholder="KG"
            class="input-light text-center me-2"
            name="ejercicios[${ejercicioCount}][peso][]">

            <input type="number" placeholder="REPS"
            class="input-light text-center me-2"
            name="ejercicios[${ejercicioCount}][series][]">

            <span class="delete-serie">✕</span>
        `;

        seriesContainer.appendChild(serie);

        serie.querySelector('.delete-serie').addEventListener('click', function() {
            serie.remove();
        });
    });
});

let seconds = 0;

function updateTimer() {
    seconds++;

    let mins = Math.floor(seconds / 60);
    let secs = seconds % 60;

    document.getElementById('timer').innerText =
        String(mins).padStart(2, '0') + ':' + String(secs).padStart(2, '0');

    document.getElementById('duracionInput').value = seconds;
}

setInterval(updateTimer, 1000);
</script>

@endsection
