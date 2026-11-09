<!-- Barra de Navegación Lateral Inteligente S.A.L.L. H.S. (Adaptativa y Plegable) -->
<!-- Capa oscura (Overlay) para cerrar el menú en móviles al hacer clic fuera -->
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
        <!-- Logotipo Miniatura y Botón de Cierre en Móvil -->
        <div class="flex items-center justify-between mb-6 xl:mb-8 px-2">
            <div class="flex items-center space-x-2 xl:space-x-3">
                <span class="text-amber-400 text-lg xl:text-xl font-black tracking-tight">S.A.L.L.</span>
                <span class="text-[10px] xl:text-xs uppercase tracking-widest text-slate-400 font-bold">H.S.</span>
            </div>
            <!-- Botón para cerrar el menú en pantallas pequeñas -->
            <button @click="sidebarOpen = false" class="md:hidden text-slate-400 hover:text-white p-1">
                <i class="bi bi-x-lg text-lg"></i>
            </button>
        </div>

        <!-- Enlaces directos a las vistas intermodulares -->
        <nav class="space-y-1.5 xl:space-y-2 text-xs font-medium">
            <a href="{{ route('recepcion.index') }}" 
               class="flex items-center space-x-2.5 xl:space-x-3 px-3 xl:px-4 py-2.5 xl:py-3 rounded-xl hover:bg-slate-900 text-slate-300 hover:text-amber-400 transition-all group">
                <i class="bi bi-bell-fill text-slate-400 group-hover:text-amber-400 transition-colors text-sm"></i>
                <span class="truncate">Recepción</span>
            </a>

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

            <a href="{{ route('comercial.index') }}" 
               class="flex items-center space-x-2.5 xl:space-x-3 px-3 xl:px-4 py-2.5 xl:py-3 rounded-xl hover:bg-slate-900 text-slate-300 hover:text-amber-400 transition-all group">
                <i class="bi bi-briefcase-fill text-slate-400 group-hover:text-amber-400 transition-colors text-sm"></i>
                <span class="truncate">Panel Comercial</span>
            </a>
            
            <a href="{{ route('pda.index') }}" 
               class="flex items-center space-x-2.5 xl:space-x-3 px-3 xl:px-4 py-2.5 xl:py-3 rounded-xl hover:bg-slate-900 text-slate-300 hover:text-amber-400 transition-all group">
                <i class="bi bi-phone-fill text-slate-400 group-hover:text-amber-400 transition-colors text-sm"></i>
                <span class="truncate">Ver Vista PDA</span>
            </a>
        </nav>
    </div>

    <!-- Botón unificado de Desconexión de Sesión -->
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