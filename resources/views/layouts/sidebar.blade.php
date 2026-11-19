<!-- Barra de Navegación Lateral Inteligente S.A.L.L. H.S. (Estilo Gran Hotel Borgoña & Bronce 3D) -->
<!-- Capa oscura (Overlay) para cerrar el menú en móviles al hacer clic fuera -->
<div x-show="sidebarOpen" 
     x-transition:enter="transition-opacity ease-linear duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     @click="sidebarOpen = false" 
     class="fixed inset-0 bg-[#140509]/80 z-40 md:hidden" 
     x-cloak></div>

<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
       class="fixed md:static inset-y-0 left-0 z-50 w-64 md:w-52 xl:w-64 bg-[#2B0D16] min-h-screen p-3.5 xl:p-4 border-r-2 border-[#120408] text-[#FDF8F4] flex flex-col justify-between shrink-0 transform md:translate-x-0 transition-transform duration-300 ease-in-out shadow-xl">
    <div>
        <!-- Logotipo Corporativo y Botón de Cierre en Móvil -->
        <div class="flex items-center justify-between mb-6 xl:mb-8 pb-4 border-b border-[#E6BE9A]/20 px-2">
            <a href="{{ url('/') }}" class="flex items-center space-x-2.5">
                <div class="w-8 h-8 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none btn-3d-bronze text-white font-serif font-bold text-base flex items-center justify-center shrink-0">
                    S
                </div>
                <div>
                    <span class="font-serif text-[#FDF8F4] text-lg xl:text-xl font-bold tracking-wide block leading-none">S.A.L.L.</span>
                    <span class="text-[9px] uppercase tracking-[0.22em] text-[#E6BE9A] font-bold block mt-0.5">H.S. Suite</span>
                </div>
            </a>
            <!-- Botón para cerrar el menú en pantallas pequeñas -->
            <button @click="sidebarOpen = false" class="md:hidden text-[#D9C4C9] hover:text-white p-1">
                <i class="bi bi-x-lg text-lg"></i>
            </button>
        </div>

        <!-- Enlaces directos a las vistas intermodulares con silueta asimétrica esculpida -->
        <nav class="space-y-1.5 xl:space-y-2 text-xs font-semibold">
            <a href="{{ route('recepcion.index') }}" 
               class="flex items-center space-x-2.5 xl:space-x-3 px-3 xl:px-4 py-2.5 xl:py-3 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none {{ request()->routeIs('recepcion.*') ? 'btn-3d-bronze text-white' : 'hover:bg-white/10 text-[#D9C4C9] hover:text-white' }} transition-all group">
                <i class="bi bi-bell-fill {{ request()->routeIs('recepcion.*') ? 'text-white' : 'text-[#E6BE9A]/70 group-hover:text-[#E6BE9A]' }} transition-colors text-sm"></i>
                <span class="truncate">Recepción</span>
            </a>

            <a href="{{ route('gobernanta.index') }}" 
               class="flex items-center space-x-2.5 xl:space-x-3 px-3 xl:px-4 py-2.5 xl:py-3 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none {{ request()->routeIs('gobernanta.*') ? 'btn-3d-bronze text-white' : 'hover:bg-white/10 text-[#D9C4C9] hover:text-white' }} transition-all group">
                <i class="bi bi-pie-chart-fill {{ request()->routeIs('gobernanta.*') ? 'text-white' : 'text-[#E6BE9A]/70 group-hover:text-[#E6BE9A]' }} transition-colors text-sm"></i>
                <span class="truncate">Gobernanta Dashboard</span>
            </a>

            <a href="{{ route('tasks.index') }}" 
               class="flex items-center space-x-2.5 xl:space-x-3 px-3 xl:px-4 py-2.5 xl:py-3 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none {{ request()->routeIs('tasks.*') ? 'btn-3d-bronze text-white' : 'hover:bg-white/10 text-[#D9C4C9] hover:text-white' }} transition-all group">
                <i class="bi bi-list-task {{ request()->routeIs('tasks.*') ? 'text-white' : 'text-[#E6BE9A]/70 group-hover:text-[#E6BE9A]' }} transition-colors text-sm"></i>
                <span class="truncate">Gestión de Tareas</span>
            </a>

            <a href="{{ route('comercial.index') }}" 
               class="flex items-center space-x-2.5 xl:space-x-3 px-3 xl:px-4 py-2.5 xl:py-3 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none {{ request()->routeIs('comercial.*') ? 'btn-3d-bronze text-white' : 'hover:bg-white/10 text-[#D9C4C9] hover:text-white' }} transition-all group">
                <i class="bi bi-briefcase-fill {{ request()->routeIs('comercial.*') ? 'text-white' : 'text-[#E6BE9A]/70 group-hover:text-[#E6BE9A]' }} transition-colors text-sm"></i>
                <span class="truncate">Panel Comercial</span>
            </a>
            
            <a href="{{ route('pda.index') }}" 
               class="flex items-center space-x-2.5 xl:space-x-3 px-3 xl:px-4 py-2.5 xl:py-3 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none {{ request()->routeIs('pda.*') ? 'btn-3d-bronze text-white' : 'hover:bg-white/10 text-[#D9C4C9] hover:text-white' }} transition-all group">
                <i class="bi bi-phone-fill {{ request()->routeIs('pda.*') ? 'text-white' : 'text-[#E6BE9A]/70 group-hover:text-[#E6BE9A]' }} transition-colors text-sm"></i>
                <span class="truncate">Ver Vista PDA</span>
            </a>
        </nav>
    </div>

    <!-- Botón unificado de Desconexión de Sesión -->
    <div class="pt-3 xl:pt-4 border-t border-[#E6BE9A]/20 text-xs font-bold">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center space-x-2.5 xl:space-x-3 px-3 xl:px-4 py-2.5 xl:py-3 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none text-[#F5DEC9] hover:bg-[#4A1926] border border-transparent hover:border-[#7A2C41] transition-all cursor-pointer">
                <i class="bi bi-box-arrow-left text-sm text-[#E6BE9A]"></i>
                <span class="truncate">Cerrar Sesión</span>
            </button>
        </form>
    </div>
</aside>