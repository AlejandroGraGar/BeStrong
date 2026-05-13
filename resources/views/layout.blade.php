<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BeStrong')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
</head>

<body class="bg-gray-100 text-gray-800 min-h-screen font-['Inter'] flex flex-col">

    @include('navbar')

    <main class="container mx-auto mt-8 px-6 pb-12 flex-1">
        @yield('content')
    </main>

    <footer class="bg-white border-t border-gray-200">

        <div class="max-w-7xl mx-auto px-6 py-6">

            <div class="flex flex-col md:flex-row items-center justify-between gap-6">

                <div>

                    <h2 class="text-xl font-black text-red-600">
                        BeStrong
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Plataforma de entrenamiento y progreso físico.
                    </p>

                </div>

                <div class="flex items-center gap-6 text-sm">

                    <a
                        href="{{ route('privacidad') }}"
                        class="text-gray-500 hover:text-red-500 transition">

                        Política de Privacidad

                    </a>

                    <a
                        href="mailto:soporte@bestrong.com"
                        class="text-gray-500 hover:text-red-500 transition">

                        Contacto

                    </a>

                </div>

            </div>

            <div class="border-t border-gray-100 mt-6 pt-4 text-center">

                <p class="text-xs text-gray-400">
                    © 2026 BeStrong. Todos los derechos reservados.
                </p>

            </div>

        </div>

    </footer>

</body>
</html>