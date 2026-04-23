@extends('layout')

@section('title', 'Editar Rutina')

@section('content')
<div class="max-w-3xl mx-auto mt-10">

    <div class="mb-6">
        <a href="{{ route('rutinas.show', $rutina) }}" class="text-gray-500 hover:text-red-500 font-medium">
            ← Volver a {{ $rutina->nombre }}
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-lg overflow-hidden">

        <div class="bg-red-500 px-8 py-6">
            <h1 class="text-2xl font-black text-white">Editar Rutina</h1>
            <p class="text-red-100 text-sm mt-1">{{ $rutina->nombre }}</p>
        </div>

        <form action="{{ route('ejercicioRutina.update', $rutina) }}" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT')

            <div id="ejercicios-container" class="space-y-4">

                @foreach($rutina->ejercicios as $ejercicio)
                    <div class="p-4 border rounded-xl space-y-3 bg-gray-50 ejercicio-item" data-id="{{ $ejercicio->id }}">
                        
                        <div class="flex justify-between items-center">
                            <p class="font-bold">{{ $ejercicio->nombre }}</p>

                            <button type="button"
                                class="text-red-500 hover:text-red-700 remove-ejercicio">
                                Eliminar
                            </button>
                        </div>

                        <input type="hidden" name="ejercicios[{{ $ejercicio->id }}][selected]" value="1">

                        <div class="grid grid-cols-2 gap-3">
                            <input type="number" name="ejercicios[{{ $ejercicio->id }}][series]"
                                   value="{{ $ejercicio->pivot->series ?? 3 }}"
                                   class="border rounded-lg p-2" placeholder="Series">

                            <input type="number" name="ejercicios[{{ $ejercicio->id }}][repeticiones]"
                                   value="{{ $ejercicio->pivot->repeticiones ?? 10 }}"
                                   class="border rounded-lg p-2" placeholder="Repeticiones">

                            <input type="number" name="ejercicios[{{ $ejercicio->id }}][peso]"
                                   value="{{ $ejercicio->pivot->peso ?? null }}"
                                   class="border rounded-lg p-2" placeholder="Peso">

                            <input type="number" name="ejercicios[{{ $ejercicio->id }}][orden]"
                                   value="{{ $ejercicio->pivot->orden ?? 0 }}"
                                   class="border rounded-lg p-2" placeholder="Orden">
                        </div>

                    </div>
                @endforeach

            </div>

            <div class="mt-6">
                <label class="font-bold text-gray-700">Añadir ejercicio</label>

                <select id="select-ejercicio" class="w-full border rounded-xl p-3 mt-2">
                    <option value="">Seleccionar ejercicio...</option>
                    @foreach($ejerciciosDisponibles as $ejercicio)
                        <option value="{{ $ejercicio->id }}">{{ $ejercicio->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-4 pt-4">
                <button type="submit"
                        class="flex-1 bg-red-500 hover:bg-red-600 text-grey-600 font-bold py-4 rounded-xl">
                    Guardar cambios
                </button>
            </div>

        </form>
    </div>
</div>

<script>
const select = document.getElementById('select-ejercicio');
const container = document.getElementById('ejercicios-container');

select.addEventListener('change', function () {

    const id = this.value;
    if (!id) return;

    const name = this.options[this.selectedIndex].text;

    const div = document.createElement('div');
    div.classList.add('p-4','border','rounded-xl','space-y-3','bg-gray-50','ejercicio-item');
    div.dataset.id = id;

    div.innerHTML = `
        <div class="flex justify-between items-center">
            <p class="font-bold">${name}</p>
            <button type="button" class="text-red-500 remove-ejercicio">Eliminar</button>
        </div>

        <input type="hidden" name="ejercicios[${id}][selected]" value="1">

        <div class="grid grid-cols-2 gap-3">
            <input type="number" name="ejercicios[${id}][series]" value="3" class="border rounded-lg p-2" placeholder="Series">
            <input type="number" name="ejercicios[${id}][repeticiones]" value="10" class="border rounded-lg p-2" placeholder="Repeticiones">
            <input type="number" name="ejercicios[${id}][peso]" class="border rounded-lg p-2" placeholder="Peso">
            <input type="number" name="ejercicios[${id}][orden]" value="0" class="border rounded-lg p-2" placeholder="Orden">
        </div>
    `;

    container.prepend(div);

    this.querySelector(`option[value="${id}"]`).remove();
    this.value = '';
});

document.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-ejercicio')) {

        const item = e.target.closest('.ejercicio-item');
        const id = item.dataset.id;

        const option = document.createElement('option');
        option.value = id;
        option.text = item.querySelector('p').innerText;

        select.appendChild(option);

        item.remove();
    }
});
</script>

@endsection
