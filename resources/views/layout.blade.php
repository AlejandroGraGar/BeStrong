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

        * {
            box-sizing: border-box;
        }

        body {
            overflow-x: hidden;
        }

        table {
            width: 100%;
        }

        @media (max-width: 640px) {
            table thead {
                display: none;
            }

            table tr {
                display: block;
                margin-bottom: 1rem;
                border-radius: 12px;
                overflow: hidden;
            }

            table td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 10px 16px;
                font-size: 0.875rem;
            }

            table td::before {
                content: attr(data-label);
                font-weight: 700;
                color: #6b7280;
                margin-right: 1rem;
                white-space: nowrap;
            }

            img {
                max-width: 100%;
                height: auto;
            }

            .rounded-3xl,
            .rounded-2xl {
                border-radius: 1rem !important;
            }
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800 min-h-screen font-['Inter'] flex flex-col">

    @include('navbar')

    <div class="w-full max-w-7xl mx-auto flex gap-6 mt-6 px-4 sm:px-6 lg:px-8 flex-1">

        <aside class="hidden lg:block w-72">
            <div class="bg-white shadow-lg rounded-3xl p-4 sticky top-6">
                <img src="{{ asset('storage/' . \App\Models\Setting::get('ad_image')) }}" alt="Publicidad" class="w-full h-48 rounded-2xl object-cover">                @auth
                    @if(auth()->user()->is_admin)
                        <form action="{{ route('admin.ad.update') }}" method="POST" enctype="multipart/form-data" class="mt-4">
                            @csrf
                            <input type="file" name="image" class="block mb-2 text-sm">

                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-gray-600 px-4 py-2 rounded-lg w-full">
                                Cambiar publicidad
                            </button>

                        </form>
                    @endif
                @endauth

            </div>
        </aside>

        <main class="flex-1">
            @yield('content')
        </main>

    </div>

    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-6">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">

                <div class="text-center md:text-left">
                    <h2 class="text-xl font-black text-red-600">BeStrong</h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Plataforma de entrenamiento y progreso físico.
                    </p>
                </div>

                <div class="flex flex-wrap justify-center items-center gap-4 text-sm">
                    <a href="{{ route('privacidad') }}" class="text-gray-500 hover:text-red-500 transition">
                        Política de Privacidad
                    </a>
                    <a href="mailto:soporte@bestrong.com" class="text-gray-500 hover:text-red-500 transition">
                        Contacto
                    </a>
                </div>

            </div>

            <div class="border-t border-gray-100 mt-6 pt-4 text-center">
                <p class="text-xs text-gray-400">© 2026 BeStrong. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

</body>
</html>