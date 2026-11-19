<!DOCTYPE html>
<html lang="es" class="h-full bg-[#ECE5DE]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S.A.L.L. H.S. — Gestión Hotelera</title>
    
    <!-- Tipografía distintiva de Gran Hotel: Cormorant Garamond (editorial) + Plus Jakarta Sans (interfaz) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;0,700;1,600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Framework CSS utilitario: Tailwind CSS cargado vía CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Configuración personalizada de familias tipográficas para Tailwind -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        serif: ['"Cormorant Garamond"', 'Georgia', 'serif'],
                    },
                }
            }
        }
    </script>
    
    <!-- Librería oficial de iconos vectoriales: Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Alpine.js para control interactivo del menú móvil -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Estilos arquitectónicos globales 3D: Borgoña, Champagne y Bronce con relieves esculpidos -->
    <style>
        [x-cloak] { display: none !important; }

        /* Banner principal en tono Borgoña profundo con bisel iluminado y sombra de elevación */
        .banner-3d-burgundy {
            background: radial-gradient(circle at top right, #521B2A 0%, #2B0D16 65%, #17050A 100%);
            border: 1px solid #6E263A;
            border-bottom: 5px solid #120408;
            box-shadow: 
                0 18px 34px -10px rgba(43, 13, 22, 0.48),
                0 4px 10px -2px rgba(43, 13, 22, 0.20),
                inset 0 1px 0 rgba(243, 217, 195, 0.28);
        }

        /* Tarjeta convexa tono marfil-champagne con relieve 3D pronunciado */
        .card-3d-champagne {
            background: linear-gradient(180deg, #FFFFFF 0%, #F9F4EF 100%);
            border: 1px solid #D8C9BE;
            border-bottom: 4px solid #BFA99B;
            box-shadow: 
                0 12px 26px -6px rgba(43, 13, 22, 0.14),
                0 3px 8px -2px rgba(43, 13, 22, 0.08),
                inset 0 1px 0 rgba(255, 255, 255, 0.98);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        /* Superficie cóncava (hundida) para filtros, buscadores y contenedores rebajados */
        .recessed-3d-champagne {
            background-color: #F2EAE3;
            border: 1px solid #D1C0B4;
            box-shadow: 
                inset 0 2px 6px rgba(43, 13, 22, 0.12),
                0 1px 0 rgba(255, 255, 255, 0.9);
        }

        /* Botón táctil en Bronce / Champagne intenso con base 3D */
        .btn-3d-bronze {
            background: linear-gradient(180deg, #CF9A67 0%, #A66E3E 100%);
            border: 1px solid #8A582E;
            border-bottom: 3px solid #5E391A;
            box-shadow: 
                0 5px 12px rgba(166, 110, 62, 0.35),
                inset 0 1px 0 rgba(255, 245, 235, 0.50);
            transition: all 0.15s ease;
        }
        .btn-3d-bronze:hover {
            background: linear-gradient(180deg, #D9A675 0%, #B37846 100%);
            transform: translateY(-1px);
        }
        .btn-3d-bronze:active {
            transform: translateY(2px);
            border-bottom-width: 1px;
        }

        /* Botón táctil secundario en Borgoña profundo con base 3D */
        .btn-3d-burgundy {
            background: linear-gradient(180deg, #521B2A 0%, #2B0D16 100%);
            border: 1px solid #1E080E;
            border-bottom: 3px solid #120408;
            box-shadow: 
                0 5px 12px rgba(43, 13, 22, 0.32),
                inset 0 1px 0 rgba(243, 217, 195, 0.25);
            transition: all 0.15s ease;
        }
        .btn-3d-burgundy:hover {
            background: linear-gradient(180deg, #632234 0%, #38111D 100%);
            transform: translateY(-1px);
        }
        .btn-3d-burgundy:active {
            transform: translateY(2px);
            border-bottom-width: 1px;
        }
    </style>
</head>
<!-- Margen perimetral (p-3 sm:p-5) para separar todos los bloques de los bordes de la pantalla -->
<body class="min-h-full flex flex-col text-stone-800 font-sans antialiased p-3 sm:p-5 gap-5" x-data="{ mobileMenuOpen: false }">

    @php
        // Obtener el rol del usuario autenticado actualmente en la sesión
        $userRole = auth()->user()->role ?? 'Comercial';

        // Determinar si el rol dispone de navegación multi-módulo en la barra superior
        $hasMultiPageNav = in_array($userRole, ['Admin', 'Limpieza', 'Gobernanta']);
    @endphp

    <!-- 1. BARRA SUPERIOR FLOTANTE EN BORGOÑA PROFUNDO CON RELIEVE 3D -->
    <header class="max-w-7xl w-full mx-auto bg-[#2B0D16] border border-[#6E263A] border-b-4 border-b-[#120408] rounded-tl-[1.75rem] rounded-br-[1.75rem] rounded-tr-none rounded-bl-none shadow-lg sticky top-3 sm:top-4 z-40 text-[#FDF8F4]">
        <div class="px-4 sm:px-6 min-h-16 py-2.5 flex items-center justify-between gap-3">
            
            <!-- Bloque de identidad corporativa con emblema asimétrico en bronce -->
            <div class="flex items-center shrink-0">
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-tl-2xl rounded-br-2xl rounded-tr-none rounded-bl-none btn-3d-bronze text-white font-serif font-bold text-xl flex items-center justify-center shrink-0">
                        S
                    </div>
                    <div class="whitespace-nowrap">
                        <span class="font-serif text-lg sm:text-xl font-bold tracking-wide text-[#FDF8F4] block leading-none">S.A.L.L. H.S.</span>
                        <span class="text-[9px] uppercase tracking-[0.22em] text-[#E6BE9A] font-bold block leading-tight mt-0.5">Grand Hospitality</span>
                    </div>
                </a>
            </div>

            <!-- Navegación horizontal de módulos para escritorio (>= 1024px) -->
            @if($hasMultiPageNav)
            <nav class="hidden lg:flex items-center gap-1.5 text-xs font-semibold whitespace-nowrap bg-[#140509]/70 p-1.5 rounded-tl-2xl rounded-br-2xl rounded-tr-none rounded-bl-none border border-[#E6BE9A]/20 shadow-inner">
                
                @if(in_array($userRole, ['Recepcion', 'Admin']))
                    <a href="{{ route('recepcion.index') }}" 
                       class="px-3.5 py-2 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none transition-all flex items-center gap-1.5 {{ request()->routeIs('recepcion.*') ? 'btn-3d-bronze text-white' : 'text-[#D9C4C9] hover:bg-white/10 hover:text-white' }}">
                        <i class="bi bi-bell"></i>
                        <span>Recepción</span>
                    </a>
                @endif

                @if(in_array($userRole, ['Limpieza', 'Gobernanta', 'Admin']))
                    <a href="{{ route('gobernanta.index') }}" 
                       class="px-3.5 py-2 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none transition-all flex items-center gap-1.5 {{ request()->routeIs('gobernanta.*') ? 'btn-3d-bronze text-white' : 'text-[#D9C4C9] hover:bg-white/10 hover:text-white' }}">
                        <i class="bi bi-grid-1x2"></i>
                        <span>Gobernanta</span>
                    </a>

                    <a href="{{ route('tasks.index') }}" 
                       class="px-3.5 py-2 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none transition-all flex items-center gap-1.5 {{ request()->routeIs('tasks.*') ? 'btn-3d-bronze text-white' : 'text-[#D9C4C9] hover:bg-white/10 hover:text-white' }}">
                        <i class="bi bi-list-check"></i>
                        <span>Tareas</span>
                    </a>
                @endif

                @if(in_array($userRole, ['Comercial', 'Admin']))
                    <a href="{{ route('comercial.index') }}" 
                       class="px-3.5 py-2 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none transition-all flex items-center gap-1.5 {{ request()->routeIs('comercial.*') ? 'btn-3d-bronze text-white' : 'text-[#D9C4C9] hover:bg-white/10 hover:text-white' }}">
                        <i class="bi bi-briefcase"></i>
                        <span>Comercial</span>
                    </a>
                @endif

                @if(in_array($userRole, ['Limpieza', 'Mantenimiento', 'Admin']))
                    <a href="{{ route('pda.index') }}" 
                       class="px-3.5 py-2 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none transition-all flex items-center gap-1.5 {{ request()->routeIs('pda.*') ? 'btn-3d-bronze text-white' : 'text-[#D9C4C9] hover:bg-white/10 hover:text-white' }}">
                        <i class="bi bi-phone"></i>
                        <span>Vista PDA</span>
                    </a>
                @endif
            </nav>
            @endif

            <!-- Bloque derecho: Rol activo, avatar con bisel y botón de salida -->
            <div class="flex items-center gap-2.5 sm:gap-3 text-xs shrink-0 whitespace-nowrap">
                <span class="hidden sm:inline-flex items-center px-2.5 py-1 rounded-tl-lg rounded-br-lg rounded-tr-none rounded-bl-none bg-[#4A1926] border border-[#7A2C41] text-[#F5DEC9] font-semibold">
                    {{ $userRole }}
                </span>

                <div class="flex items-center gap-2 border-l border-[#E6BE9A]/20 pl-2.5 sm:pl-3">
                    <span class="font-medium text-[#FDF8F4] hidden xl:inline">{{ auth()->user()->name ?? 'Admin' }}</span>
                    <div class="w-8 h-8 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none bg-[#4A1926] border border-[#E6BE9A]/35 text-[#F5DEC9] font-serif font-bold flex items-center justify-center text-sm shadow-inner shrink-0">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                </div>

                <!-- Formulario POST para cierre de sesión seguro -->
                <form action="{{ route('logout') }}" method="POST" class="inline-block">
                    @csrf
                    <button type="submit" class="px-2.5 sm:px-3 py-1.5 bg-white/10 hover:bg-[#A66E3E] text-[#FDF8F4] hover:text-white border border-[#E6BE9A]/25 font-semibold rounded-tl-lg rounded-br-lg rounded-tr-none rounded-bl-none text-xs transition-all flex items-center gap-1.5 cursor-pointer">
                        <i class="bi bi-box-arrow-right"></i>
                        <span class="hidden sm:inline">Salir</span>
                    </button>
                </form>

                <!-- Botón hamburguesa para pantallas menores a 1024px -->
                @if($hasMultiPageNav)
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 rounded-lg border border-[#E6BE9A]/30 text-[#FDF8F4] hover:bg-white/10">
                    <i class="bi bi-list text-lg"></i>
                </button>
                @endif
            </div>
        </div>

        <!-- Menú desplegable responsivo para dispositivos móviles y tabletas -->
        @if($hasMultiPageNav)
        <div x-show="mobileMenuOpen" x-cloak class="lg:hidden bg-[#17050A] border-t border-[#E6BE9A]/15 px-4 py-3 space-y-1.5 text-xs rounded-br-[1.75rem]">
            @if(in_array($userRole, ['Recepcion', 'Admin']))
                <a href="{{ route('recepcion.index') }}" class="block px-3 py-2 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none {{ request()->routeIs('recepcion.*') ? 'btn-3d-bronze text-white font-semibold' : 'text-[#D9C4C9] hover:bg-white/10' }}">Recepción</a>
            @endif
            @if(in_array($userRole, ['Limpieza', 'Gobernanta', 'Admin']))
                <a href="{{ route('gobernanta.index') }}" class="block px-3 py-2 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none {{ request()->routeIs('gobernanta.*') ? 'btn-3d-bronze text-white font-semibold' : 'text-[#D9C4C9] hover:bg-white/10' }}">Gobernanta</a>
                <a href="{{ route('tasks.index') }}" class="block px-3 py-2 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none {{ request()->routeIs('tasks.*') ? 'btn-3d-bronze text-white font-semibold' : 'text-[#D9C4C9] hover:bg-white/10' }}">Gestión de Tareas</a>
            @endif
            @if(in_array($userRole, ['Comercial', 'Admin']))
                <a href="{{ route('comercial.index') }}" class="block px-3 py-2 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none {{ request()->routeIs('comercial.*') ? 'btn-3d-bronze text-white font-semibold' : 'text-[#D9C4C9] hover:bg-white/10' }}">Panel Comercial</a>
            @endif
            @if(in_array($userRole, ['Limpieza', 'Mantenimiento', 'Admin']))
                <a href="{{ route('pda.index') }}" class="block px-3 py-2 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none {{ request()->routeIs('pda.*') ? 'btn-3d-bronze text-white font-semibold' : 'text-[#D9C4C9] hover:bg-white/10' }}">Vista PDA</a>
            @endif
        </div>
        @endif
    </header>

    <!-- 2. CONTENEDOR PRINCIPAL DE VISTAS DINÁMICAS -->
    <main class="flex-1 max-w-7xl w-full mx-auto">
        @yield('content')
    </main>

    <!-- 3. PIE DE PÁGINA GLOBAL -->
    @include('layouts.footer')

</body>
</html>