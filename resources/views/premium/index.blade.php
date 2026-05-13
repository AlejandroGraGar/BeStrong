@extends('layout')

@section('title', 'BeStrong Premium')

@section('content')

<div class="max-w-6xl mx-auto px-6 py-12">

    <div class="bg-gradient-to-r from-red-600 to-red-500 rounded-3xl p-10 text-grey-600 shadow-2xl">

        <div class="max-w-3xl">

            <p class="uppercase tracking-[0.3em] text-red-100 font-bold mb-4">
                BESTRONG PRO
            </p>

            <h1 class="text-5xl font-black leading-tight mb-6">
                Lleva tus entrenamientos al siguiente nivel
            </h1>

            <p class="text-red-100 text-lg leading-relaxed">
                Desbloquea funciones exclusivas y mejora tu experiencia dentro de BeStrong.
            </p>

        </div>

    </div>

    <div class="bg-white rounded-3xl shadow-2xl p-10 mt-14 border border-gray-100">

        <div class="text-center">

            <p class="text-red-500 font-bold uppercase tracking-widest mb-3">
                PLAN PREMIUM
            </p>

            <h2 class="text-5xl font-black text-gray-900 mb-4">
                BeStrong Pro
            </h2>

            <div class="flex justify-center items-end gap-2 mb-8">

                <span class="text-6xl font-black text-red-600">
                    4,99€
                </span>

                <span class="text-gray-400 text-xl mb-2">
                    /mes
                </span>

            </div>

            <div class="max-w-2xl mx-auto">

                <div class="grid md:grid-cols-2 gap-4 text-left mb-10">

                    <div class="bg-gray-50 rounded-2xl p-4 font-semibold text-gray-700">
                        ✔ Rutinas ilimitadas
                    </div>

                </div>

                <a
                    href="{{ route('premium.pago') }}"
                    class="inline-block w-full md:w-auto bg-red-500 hover:bg-red-600 transition-all duration-200 text-grey-600 font-black text-lg px-12 py-5 rounded-2xl shadow-lg text-center">

                    Mejorar a BeStrong Pro

                </a>

            </div>

        </div>

    </div>

</div>

@endsection