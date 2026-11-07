<!-- Barra de Navegación Lateral Inteligente S.A.L.L. H.S. -->
<div class="w-64 bg-slate-950 min-h-screen p-4 border-r border-slate-800 text-white flex flex-col justify-between shrink-0">
    <div>
        <!-- Logotipo Miniatura -->
        <div class="flex items-center space-x-3 mb-8 px-2">
            <span class="text-amber-400 text-xl font-black">S.A.L.L.</span>
            <span class="text-xs uppercase tracking-widest text-slate-400 font-bold">H.S.</span>
        </div>

        <!-- Enlaces directos a las vistas intermodulares -->
        <nav class="space-y-2 text-xs font-medium">
            <a href="{{ route('recepcion.index') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-slate-900 text-slate-300 hover:text-amber-400 transition-all group">
                <i class="bi bi-bell-fill text-slate-400 group-hover:text-amber-400 transition-colors"></i>
                <span>Recepción</span>
            </a>

            <a href="{{ route('gobernanta.index') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-slate-900 text-slate-300 hover:text-amber-400 transition-all group">
                <i class="bi bi-pie-chart-fill text-slate-400 group-hover:text-amber-400 transition-colors"></i>
                <span>Gobernanta Dashboard</span>
            </a>

            <a href="{{ route('tasks.index') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-slate-900 text-slate-300 hover:text-amber-400 transition-all group">
                <i class="bi bi-list-task text-slate-400 group-hover:text-amber-400 transition-colors"></i>
                <span>Gestión de Tareas</span>
            </a>

            <a href="{{ route('comercial.index') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-slate-900 text-slate-300 hover:text-amber-400 transition-all group">
                <i class="bi bi-briefcase-fill text-slate-400 group-hover:text-amber-400 transition-colors"></i>
                <span>Panel Comercial</span>
            </a>
            
            <a href="{{ route('pda.index') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-slate-900 text-slate-300 hover:text-amber-400 transition-all group">
                <i class="bi bi-phone-fill text-slate-400 group-hover:text-amber-400 transition-colors"></i>
                <span>Ver Vista PDA</span>
            </a>
        </nav>
    </div>

    <!-- Botón unificado de Desconexión de Sesión -->
    <div class="pt-4 border-t border-slate-800 text-xs font-bold">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-rose-400 hover:bg-rose-950/20 transition-all cursor-pointer">
                <i class="bi bi-box-arrow-left"></i>
                <span>Cerrar Sesión</span>
            </button>
        </form>
    </div>
</div>
