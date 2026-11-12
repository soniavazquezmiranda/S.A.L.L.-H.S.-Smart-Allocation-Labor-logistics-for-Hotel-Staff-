<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S.A.L.L. H.S. — Panel de Control</title>
    
    <!-- Fuente oficial del sistema: Inter (Google Fonts) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Framework de estilos: Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    
    <!-- Librería de iconos oficiales: Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Alpine.js para control interactivo del Sidebar en móviles -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak] { display: none !important; }</style>

    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
</head>
<body class="h-full flex text-slate-800 font-sans antialiased overflow-x-hidden" x-data="{ sidebarOpen: false }">

    @php
        $userRole = auth()->user()->role ?? 'Comercial';
        // Determinar si el usuario tiene navegación multi-página (Admin incluye vista completa de todo el sistema)
        $hasMultiPageNav = in_array($userRole, ['Admin', 'Limpieza', 'Gobernanta']);
    @endphp

    <!-- 1. BARRA LATERAL (Se renderiza para Admin y roles multi-página) -->
    @if($hasMultiPageNav)
        <div x-show="sidebarOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false" 
             class="fixed inset-0 bg-slate-950/80 z-40 md:hidden" 
             x-cloak></div>

        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
               class="fixed md:static inset-y-0 left-0 z-50 w-64 md:w-48 xl:w-64 bg-slate-950 min-h-screen p-3 xl:p-4 border-r border-slate-800 text-white flex flex-col justify-between shrink-0 transform md:translate-x-0 transition-transform duration-300 ease-in-out">
            <div>
                <div class="flex items-center justify-between mb-6 xl:mb-8 px-2">
                    <div class="flex items-center space-x-2 xl:space-x-3">
                        <span class="text-amber-400 text-lg xl:text-xl font-black tracking-tight">S.A.L.L.</span>
                        <span class="text-[10px] xl:text-xs uppercase tracking-widest text-slate-400 font-bold">H.S.</span>
                    </div>
                    <button @click="sidebarOpen = false" class="md:hidden text-slate-400 hover:text-white p-1">
                        <i class="bi bi-x-lg text-lg"></i>
                    </button>
                </div>

                <nav class="space-y-1.5 xl:space-y-2 text-xs font-medium">
                    
                    {{-- 1. RECEPCIÓN: Visible para 'Recepcion' o 'Admin' --}}
                    @if(in_array($userRole, ['Recepcion', 'Admin']))
                        <a href="{{ route('recepcion.index') }}" 
                           class="flex items-center space-x-2.5 xl:space-x-3 px-3 xl:px-4 py-2.5 xl:py-3 rounded-xl hover:bg-slate-900 text-slate-300 hover:text-amber-400 transition-all group">
                            <i class="bi bi-bell-fill text-slate-400 group-hover:text-amber-400 transition-colors text-sm"></i>
                            <span class="truncate">Recepción</span>
                        </a>
                    @endif

                    {{-- 2. GOBERNANTA Y TAREAS: Visible para 'Limpieza', 'Gobernanta' o 'Admin' --}}
                    @if(in_array($userRole, ['Limpieza', 'Gobernanta', 'Admin']))
                        <a href="{{ route('gobernanta.index') }}" 
                           class="flex items-center space-x-2.5 xl:space-x-3 px-3 xl:px-4 py-2.5 xl:py-3 rounded-xl hover:bg-slate-900 text-slate-300 hover:text-amber-400 transition-all group">
                            <i class="bi bi-pie-chart-fill text-slate-400 group-hover:text-amber-400 transition-colors text-sm"></i>
                            <span class="truncate">Gobernanta Dashboard</span>
                        </a>

                        <a href="{{ route('tasks.index') }}" 
                           class="flex items-center space-x-2.5 xl:space-x-3 px-3 xl:px-4 py-2.5 xl:py-3 rounded-xl hover:bg-slate-900 text-slate-300 hover:text-amber-400 transition-all group">
                            <i class="bi bi-list-task text-slate-400 group-hover:text-amber-400 transition-colors text-sm"></i>
                            <span class="truncate">Gestión de Tareas</span>
                        </a>
                    @endif

                    {{-- 3. COMERCIAL: Visible para 'Comercial' o 'Admin' --}}
                    @if(in_array($userRole, ['Comercial', 'Admin']))
                        <a href="{{ route('comercial.index') }}" 
                           class="flex items-center space-x-2.5 xl:space-x-3 px-3 xl:px-4 py-2.5 xl:py-3 rounded-xl hover:bg-slate-900 text-slate-300 hover:text-amber-400 transition-all group">
                            <i class="bi bi-briefcase-fill text-slate-400 group-hover:text-amber-400 transition-colors text-sm"></i>
                            <span class="truncate">Panel Comercial</span>
                        </a>
                    @endif

                    {{-- 4. VISTA PDA: Visible para 'Limpieza', 'Mantenimiento' o 'Admin' --}}
                    @if(in_array($userRole, ['Limpieza', 'Mantenimiento', 'Admin']))
                        <a href="{{ route('pda.index') }}" 
                           class="flex items-center space-x-2.5 xl:space-x-3 px-3 xl:px-4 py-2.5 xl:py-3 rounded-xl hover:bg-slate-900 text-slate-300 hover:text-amber-400 transition-all group">
                            <i class="bi bi-phone-fill text-slate-400 group-hover:text-amber-400 transition-colors text-sm"></i>
                            <span class="truncate">Vista PDA</span>
                        </a>
                    @endif

                </nav>
            </div>

            <div class="pt-3 xl:pt-4 border-t border-slate-800 text-xs font-bold">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center space-x-2.5 xl:space-x-3 px-3 xl:px-4 py-2.5 xl:py-3 rounded-xl text-rose-400 hover:bg-rose-950/20 transition-all cursor-pointer">
                        <i class="bi bi-box-arrow-left text-sm"></i>
                        <span class="truncate">Cerrar Sesión</span>
                    </button>
                </form>
            </div>
        </aside>
    @endif

    <!-- CONTENEDOR PRINCIPAL DERECHO (Toma el 100% de ancho si no hay sidebar) -->
    <div class="flex-1 flex flex-col min-w-0 min-h-screen">

        <!-- 2. CABECERA GLOBAL SUPERIOR (TOP BAR) -->
        <header class="bg-white border-b border-slate-200 px-4 sm:px-6 py-3 flex items-center justify-between">
            <div class="flex items-center gap-3">
                @if($hasMultiPageNav)
                    <!-- Botón Hamburguesa solo si hay menú desplegable -->
                    <button @click="sidebarOpen = true" class="md:hidden p-2 text-slate-600 hover:text-slate-900 focus:outline-none rounded-lg border border-slate-200 bg-slate-50">
                        <i class="bi bi-list text-xl"></i>
                    </button>
                @else
                    <!-- Logotipo para roles de vista única (Comercial, Recepción) -->
                    <div class="flex items-center space-x-2">
                        <span class="text-slate-900 text-base font-black tracking-tight">S.A.L.L.</span>
                        <span class="text-[10px] uppercase tracking-widest text-amber-600 font-bold">H.S.</span>
                    </div>
                @endif

                <span class="text-xs font-bold uppercase tracking-wider text-slate-400 hidden sm:inline border-l border-slate-200 pl-3">Módulo Activo:</span>
                <span class="px-2.5 py-1 bg-amber-100 text-amber-900 rounded-lg text-xs font-bold">
                    {{ $userRole }}
                </span>
            </div>
            
            <div class="flex items-center gap-3 sm:gap-4 text-xs">
                <div class="flex items-center gap-2">
                    <span class="font-medium text-slate-700 hidden sm:inline">{{ auth()->user()->name ?? 'Liudmyla' }}</span>
                    <div class="w-8 h-8 rounded-full bg-slate-900 text-amber-400 font-bold flex items-center justify-center text-xs shadow-sm">
                        {{ strtoupper(substr(auth()->user()->name ?? 'L', 0, 1)) }}
                    </div>
                </div>

                <!-- Botón de Cerrar Sesión directo en Top Bar para vistas únicas -->
                <form action="{{ route('logout') }}" method="POST" class="inline-block border-l border-slate-200 pl-3">
                    @csrf
                    <button type="submit" class="p-1.5 sm:px-3 sm:py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 font-semibold rounded-xl text-xs transition-all flex items-center gap-1.5 cursor-pointer">
                        <i class="bi bi-box-arrow-right text-sm"></i>
                        <span class="hidden sm:inline">Cerrar Sesión</span>
                    </button>
                </form>
            </div>
        </header>

        <!-- 3. CUERPO DINÁMICO -->
        <main class="flex-1 p-3 sm:p-6 overflow-y-auto">
            @yield('content')
        </main>

        <!-- 4. PIE DE PÁGINA (Footer Global) -->
        @include('layouts.footer')

    </div>

</body>
</html>