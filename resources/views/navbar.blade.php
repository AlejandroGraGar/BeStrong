<header class="sticky top-0 z-50 shadow-lg">
    <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-4">

        <a href="{{ url('/') }}" class="flex items-center gap-3 group">
            <div class="p-2 bg-white/20 backdrop-blur rounded-xl group-hover:bg-white/30 transition-colors">
                <img src="{{ asset('storage/logo.png') }}" alt="Logo" class="h-16 w-16">
            </div>
            <span class="text-2xl font-bold btn text-red tracking-tight">BeStrong</span>
        </a >

        <nav class="flex items-center gap-1">
            <a href="{{ url('/') }}" class="px-4 py-2 btn  text-white/90 hover:text-white hover:bg-white/20 rounded-lg font-medium transition-all">Inicio</a>
            <a href="{{ url('/rutinas') }}" class="px-4 py-2 btn  text-white/90 hover:text-white hover:bg-white/20 rounded-lg font-medium transition-all">Rutinas</a>
            <a href="{{ url('/ejercicios') }}" class="px-4 py-2 btn  text-white/90 hover:text-white hover:bg-white/20 rounded-lg font-medium transition-all">Ejercicios</a>
            <a href="{{ url('/perfil') }}" class="px-4 py-2 btn  text-white/90 hover:text-white hover:bg-white/20 rounded-lg font-medium transition-all">Perfil</a>

        </nav>
        
        @if(auth()->check() && auth()->user()->datosUsuario && auth()->user()->datosUsuario->premium)

            <span class="text-4xl">
                👑 
            </span>

        @else

            <a href="{{ url('/premium') }}" class="px-5 py-2.5 bg-white hover:bg-gray-100 rounded-xl font-semibold text-red-600 shadow-lg transition-all">
                PRO
            </a>

        @endif

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger">
                Cerrar sesión
            </button>
        </form>
    </div>
        
</header>