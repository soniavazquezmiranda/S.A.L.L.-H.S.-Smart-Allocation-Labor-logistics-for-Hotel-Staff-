<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S.A.L.L. H.S.</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen flex flex-col">

    @php
        $userRole = auth()->user()->role ?? null;
    @endphp

    <header class="bg-slate-900 text-white px-6 py-3 flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-6">
            <a href="{{ url('/') }}" class="font-bold text-amber-400">S.A.L.L. H.S.</a>
            
            @auth
                <nav class="flex flex-wrap gap-4 text-sm">
                    @if(in_array($userRole, ['Recepcion', 'Admin']))
                        <a href="{{ route('recepcion.index') }}" class="hover:text-amber-400">Recepción</a>
                    @endif

                    @if(in_array($userRole, ['Gobernanta', 'Admin']))
                        <a href="{{ route('gobernanta.index') }}" class="hover:text-amber-400">Gobernanta</a>
                        <a href="{{ route('tasks.index') }}" class="hover:text-amber-400">Tareas</a>
                    @endif

                    @if(in_array($userRole, ['Comercial', 'Admin']))
                        <a href="{{ route('comercial.index') }}" class="hover:text-amber-400">Comercial</a>
                    @endif

                    @if(in_array($userRole, ['Trabajador', 'Admin']))
                        <a href="{{ route('pda.index') }}" class="hover:text-amber-400">PDA</a>
                    @endif
                </nav>
            @endauth
        </div>

        <div class="flex items-center gap-4 text-sm">
            @auth
                <span><strong>{{ auth()->user()->name }}</strong> ({{ $userRole }})</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-rose-600 hover:bg-rose-700 px-3 py-1 rounded text-xs font-semibold">
                        Salir
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="bg-amber-500 text-slate-950 px-3 py-1 rounded text-xs font-bold">
                    Iniciar Sesión
                </a>
            @endauth
        </div>
    </header>

    <main class="flex-1 p-6 max-w-7xl w-full mx-auto">
        @yield('content')
    </main>

</body>
</html>