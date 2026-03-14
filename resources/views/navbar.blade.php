<header class="bg-red-600 text-white shadow-md">
    <div class="container mx-auto flex items-center justify-between p-4">
        
        <!-- Logo -->
        <a href="{{ url('/') }}" class="flex items-center">
            <img src="{{ asset('storage/logo.png') }}" alt="Logo" class="h-10 w-10 mr-2">
            <span class="font-bold text-lg">BeStrong</span>
        </a>

        <!-- Navegación -->
        <nav>
            <ul class="flex space-x-6">
                <li><a href="{{ url('/') }}" class="hover:underline">Inicio</a></li>
                <li><a href="{{ url('/rutinas') }}" class="hover:underline">Rutinas</a></li>
                <li><a href="{{ url('/ejercicios') }}" class="hover:underline">Ejercicios</a></li>
                <li><a href="{{ url('/perfil') }}" class="hover:underline">Perfil</a></li>
                <li><a href="{{ url('/ajustes') }}" class="hover:underline">Ajustes</a></li>
            </ul>
        </nav>
    </div>
</header>
