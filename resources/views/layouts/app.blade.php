<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S.A.L.L. H.S.</title>
    <!-- Tailwind CDN temporal para que las vistas de prueba tengan estilos sin compilar -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen flex flex-col">

    <!-- Barra superior básica de navegación para pruebas en develop -->
    <header class="bg-slate-900 text-white px-6 py-3 flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-6">
            <span class="font-bold text-amber-400">S.A.L.L. H.S. (Base Develop)</span>
            
            <nav class="flex flex-wrap gap-4 text-sm">
                <a href="{{ route('recepcion.index') }}" class="hover:text-amber-400">Recepción</a>
                <a href="{{ route('gobernanta.index') }}" class="hover:text-amber-400">Gobernanta</a>
                <a href="{{ route('comercial.index') }}" class="hover:text-amber-400">Comercial</a>
                <a href="{{ route('pda.index') }}" class="hover:text-amber-400">PDA</a>
            </nav>
        </div>

        <div class="flex items-center gap-4 text-sm">
            <span>Usuario: <strong>{{ auth()->user()->name ?? 'Invitado' }}</strong> ({{ auth()->user()->role ?? 'Sin rol' }})</span>
            
        </div>
    </header>

    <!-- Contenido dinámico de cada módulo -->
    <main class="flex-1 p-6 max-w-7xl w-full mx-auto">
        @yield('content')
    </main>

</body>
</html>