<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BeStrong')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <linkhref="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

<style>
    button,
    .btn,
    a[class*="bg-"] {
        transition: all 0.2s ease;
    }

    button:hover,
    .btn:hover,
    a[class*="bg-"]:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 10px 20px rgba(0,0,0,0.12);
    }

    button:active,
    .btn:active,
    a[class*="bg-"]:active {
        transform: scale(0.98);
    }
</style>
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
                    <a href="{{ route('privacidad') }}" class="text-gray-500 hover:text-red-500 transition"> 
                        Política de Privacidad
                    </a>

                    <a href="mailto:soporte@bestrong.com" class="text-gray-500 hover:text-red-500 transition">
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