@extends('layout')

@section('title', 'Pagar Suscripción')

@section('content')

<div class="max-w-2xl mx-auto px-6 py-16">

    <div class="bg-white rounded-3xl shadow-2xl p-10 border border-gray-100">

        <h1 class="text-4xl font-black text-gray-900 mb-8 text-center">
            Pagar BeStrong Pro
        </h1>

        <form class="space-y-6">

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Nombre en la tarjeta
                </label>

                <input type="text" class="w-full bg-gray-100 rounded-2xl px-4 py-4 outline-none">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Número de tarjeta
                </label>

                <input type="text" maxlength="16" pattern="[0-9]{16}" class="w-full bg-gray-100 rounded-2xl px-4 py-4 outline-none">
            </div>

            <div class="grid grid-cols-2 gap-4">

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        MM/AA
                    </label>

                    <input type="text" maxlength="5" pattern="(0[1-9]|1[0-2])\/[0-9]{2}" class="w-full bg-gray-100 rounded-2xl px-4 py-4 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        CVV
                    </label>

                    <input type="text" maxlength="3" pattern="[0-9]{3}" class="w-full bg-gray-100 rounded-2xl px-4 py-4 outline-none">
                </div>

            </div>

            <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-black py-5 rounded-2xl text-lg">
                Pagar 4,99€
            </button>

        </form>

    </div>

</div>

@endsection