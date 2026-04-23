<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BeStrong')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-800 min-h-screen font-['Inter'] flex flex-col">

    @include('navbar')

    <main class="container mx-auto mt-8 px-6 pb-12 flex-1">
        @yield('content')
    </main>

    <footer class="border-t border-gray-200 bg-white">
        <div class="container mx-auto px-6 py-6">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <span class="font-bold text-lg text-gray-800">Be<span class="text-red-500">Strong</span> <span class="text-gray-400 text-sm font-normal">© 2025</span></span>
                <div class="flex items-center gap-6 text-sm text-gray-500">
                    <a href="{{ url('/terminos') }}" class="hover:text-red-500 transition-colors">Términos</a>
                    <a href="{{ url('/privacidad') }}" class="hover:text-red-500 transition-colors">Privacidad</a>
                    <a href="{{ url('/contacto') }}" class="hover:text-red-500 transition-colors">Contacto</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>