@extends('layouts.app')

@section('content')
<!-- Estilos específicos para las celdas interactivas del mapa de habitaciones 3D -->
<style>
    .room-cell {
        padding: 0.5rem 0.25rem;
        text-align: center;
        border-radius: 0.85rem 0 0.85rem 0;
        transition: all 0.15s ease;
        cursor: pointer;
        user-select: none;
    }
    .room-cell:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(43, 13, 22, 0.18);
    }
    /* [L] Lista / Disponible (Tono Champagne cálido con borde bronce) */
    .status-L {
        background: linear-gradient(180deg, #FFFFFF 0%, #F7EFE6 100%);
        border: 1px solid #DEC7AF;
        border-bottom: 3px solid #C4A484;
        color: #2B0D16;
    }
    /* [S] Sucia / Check-out pendiente (Tono Borgoña intenso) */
    .status-S {
        background: linear-gradient(180deg, #632234 0%, #3B121E 100%);
        border: 1px solid #7A2C41;
        border-bottom: 3px solid #1A060C;
        color: #FDF8F4;
    }
    /* [P] En Proceso de Limpieza (Tono Bronce cobrizo) */
    .status-P {
        background: linear-gradient(180deg, #D9A675 0%, #A66E3E 100%);
        border: 1px solid #8A582E;
        border-bottom: 3px solid #5E391A;
        color: #FFFFFF;
    }
    /* [A] Avería / Bloqueada Mantenimiento (Tono Carmesí alerta) */
    .status-A {
        background: linear-gradient(180deg, #BE123C 0%, #881337 100%);
        border: 1px solid #9F1239;
        border-bottom: 3px solid #4C0519;
        color: #FFF1F2;
    }
</style>

@php
    // Cálculo dinámico basado en las variables reales enviadas por GobernantaController
    $ocupadas = $occupiedRooms ?? 38;
    $sucias = $dirtyRooms ?? 9;
    $disponibles = $availableRooms ?? 38;
    $mantenimiento = $maintenanceRooms ?? 1;
    $totalInventario = ($ocupadas + $sucias + $disponibles + $mantenimiento) ?: 52;
@endphp

<div class="space-y-6">

    <!-- 1. BANNER PRINCIPAL EN BORGOÑA PROFUNDO CON CURVATURA ASIMÉTRICA Y MARCO INTERIOR -->
    <header class="banner-3d-burgundy rounded-tl-[2.25rem] rounded-br-[2.25rem] rounded-tr-none rounded-bl-none p-3 sm:p-4 text-white">
        <div class="rounded-tl-[1.75rem] rounded-br-[1.75rem] rounded-tr-none rounded-bl-none border border-[#E6BE9A]/25 p-5 sm:p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="min-w-0">
                <div class="flex items-center gap-2 text-[11px] uppercase tracking-[0.24em] text-[#E6BE9A] font-bold mb-1.5">
                    <span>Housekeeping &amp; Control de Pisos</span>
                    <span>•</span>
                    <span>{{ $totalInventario }} Unidades</span>
                </div>
                <h1 class="font-serif text-3xl sm:text-4xl font-bold text-[#FDF8F4] tracking-tight">
                    Hotel Grand Central <span class="italic font-semibold text-[#E6BE9A]">— Gobernanta</span>
                </h1>
                <p class="text-xs text-[#D9C4C9] mt-1.5">
                    Supervisión en tiempo real de camareras de piso, estado de habitaciones y tiempos SLA
                </p>
            </div>

            <!-- Bloque de supervisión con cápsula asimétrica rebajada -->
            <div class="flex items-center gap-3 text-xs bg-[#140509]/70 border border-[#E6BE9A]/30 px-4 py-2.5 rounded-tl-2xl rounded-br-2xl rounded-tr-none rounded-bl-none shadow-inner shrink-0 whitespace-nowrap">
                <div class="text-left sm:text-right">
                    <span class="text-[#C7AEB5] block text-[10px] uppercase tracking-wider">Gobernanta Jefe</span>
                    <strong class="text-[#FDF8F4] text-xs">{{ auth()->user()->name ?? 'Sonia' }}</strong>
                </div>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-tl-lg rounded-br-lg rounded-tr-none rounded-bl-none bg-[#4A1926] border border-[#7A2C41] text-[#F5DEC9] font-semibold text-[11px]">
                    <span class="w-2 h-2 rounded-full bg-[#E6BE9A] animate-pulse"></span>
                    PDA Sync
                </span>
            </div>
        </div>
    </header>

    <!-- 2. TARJETAS KPI SINCRONIZADAS CON EL MAPA DE HABITACIONES -->
    <section class="grid grid-cols-1 min-[480px]:grid-cols-2 lg:grid-cols-4 gap-5 text-xs">
        
        <!-- KPI 1: Total de Habitaciones en el Mapa -->
        <div class="card-3d-champagne p-5 rounded-tl-[1.75rem] rounded-br-[1.75rem] rounded-tr-none rounded-bl-none border-l-[5px] border-l-[#2B0D16] flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[11px] text-stone-600 uppercase font-bold tracking-wider">Total Habitaciones</span>
                <span class="w-8 h-8 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none bg-[#F3ECE6] border border-[#D6C7BC] flex items-center justify-center text-[#2B0D16]">
                    <i class="bi bi-building text-sm"></i>
                </span>
            </div>
            <div class="font-serif text-4xl font-bold text-[#2B0D16] my-2.5" id="kpi-total-count">52</div>
            <p class="text-[11px] text-stone-500">
                <span id="kpi-maintenance-count">1</span> en avería [A] · {{ $occupiedRooms ?? 0 }} ocupadas (BD)
            </p>
        </div>

        <!-- KPI 2: Habitaciones Listas [L] -->
        <div class="card-3d-champagne p-5 rounded-tl-[1.75rem] rounded-br-[1.75rem] rounded-tr-none rounded-bl-none border-l-[5px] border-l-[#A87344] flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[11px] text-[#8C5C32] uppercase font-bold tracking-wider">Listas [L]</span>
                <span class="w-8 h-8 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none bg-[#F7EFE6] border border-[#DEC7AF] flex items-center justify-center text-[#A87344]">
                    <i class="bi bi-check2-circle text-sm"></i>
                </span>
            </div>
            <div class="font-serif text-4xl font-bold text-[#9E6838] my-2.5" id="kpi-clean-count">0</div>
            <p class="text-[11px] text-[#8C5C32]/85 font-medium">Disponibles para asignación</p>
        </div>

        <!-- KPI 3: Habitaciones Sucias [S] -->
        <div class="card-3d-champagne p-5 rounded-tl-[1.75rem] rounded-br-[1.75rem] rounded-tr-none rounded-bl-none border-l-[5px] border-l-[#632234] flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[11px] text-stone-600 uppercase font-bold tracking-wider">Sucias [S]</span>
                <span class="w-8 h-8 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none bg-[#F3ECE6] border border-[#D6C7BC] flex items-center justify-center text-[#632234]">
                    <i class="bi bi-stars text-sm"></i>
                </span>
            </div>
            <div class="font-serif text-4xl font-bold text-[#4A1926] my-2.5" id="kpi-dirty-count">0</div>
            <p class="text-[11px] text-stone-500">Pendientes de limpieza</p>
        </div>

        <!-- KPI 4: Habitaciones En Proceso [P] -->
        <div class="card-3d-champagne p-5 rounded-tl-[1.75rem] rounded-br-[1.75rem] rounded-tr-none rounded-bl-none border-l-[5px] border-l-[#CF9A67] flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[11px] text-[#8C5C32] uppercase font-bold tracking-wider">En Proceso [P]</span>
                <span class="w-8 h-8 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none bg-[#F7EFE6] border border-[#DEC7AF] flex items-center justify-center text-[#A66E3E]">
                    <i class="bi bi-arrow-repeat text-sm"></i>
                </span>
            </div>
            <div class="font-serif text-4xl font-bold text-[#8C5C32] my-2.5" id="kpi-process-count">0</div>
            <p class="text-[11px] text-stone-500">Camareras trabajando en piso</p>
        </div>

    </section>

    <!-- 3. BLOQUE DE INCIDENCIAS CRÍTICAS PENDIENTES ($urgentTasks) -->
    @if(count($urgentTasks ?? []) > 0)
    <section class="card-3d-champagne p-5 rounded-tl-[2rem] rounded-br-[2rem] rounded-tr-none rounded-bl-none border-l-[5px] border-l-rose-800 space-y-3 text-xs">
        <div class="flex items-center justify-between">
            <span class="text-[11px] font-bold uppercase tracking-wider text-rose-900 flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-rose-700 animate-ping"></span>
                Incidencias Críticas Pendientes (Prioridad Alta)
            </span>
            <a href="{{ route('tasks.index') }}" class="btn-3d-burgundy px-3 py-1.5 text-[#FDF8F4] font-bold rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none text-[11px]">
                Abrir Panel de Tareas
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach($urgentTasks as $incidencia)
                <div class="recessed-3d-champagne p-3.5 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none space-y-1">
                    <div class="flex items-center justify-between">
                        <strong class="font-serif text-base text-[#2B0D16]">
                            Hab. {{ $incidencia->room->room_number ?? $incidencia->room_id ?? 'General' }}
                        </strong>
                        <span class="px-2 py-0.5 rounded-tl-md rounded-br-md rounded-tr-none rounded-bl-none bg-rose-900 text-white text-[10px] font-bold uppercase">
                            {{ $incidencia->priority ?? 'High' }}
                        </span>
                    </div>
                    <p class="font-semibold text-stone-800">{{ $incidencia->title }}</p>
                    <p class="text-[11px] text-stone-500">Asignado: {{ $incidencia->user->name ?? 'Sin asignar' }}</p>
                </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- 4. MAPA VISUAL INTERACTIVO DEL HOTEL POR PLANTAS -->
    <section class="card-3d-champagne p-6 sm:p-7 rounded-tl-[2rem] rounded-br-[2rem] rounded-tr-none rounded-bl-none border-t-[5px] border-t-[#2B0D16] space-y-5 text-xs">
        
        <!-- Cabecera del mapa, leyenda de colores y selector de planta -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 border-b border-stone-200 pb-4">
            <div>
                <span class="text-[10px] font-bold uppercase text-[#8C5C32] tracking-[0.22em] block">Mapa Visual en Tiempo Real</span>
                <h2 class="font-serif text-2xl font-bold text-[#2B0D16] mt-0.5">Distribución por Plantas (52 Habitaciones)</h2>
            </div>

            <!-- Leyenda de estados operativos -->
            <div class="flex flex-wrap items-center gap-3 text-[11px] recessed-3d-champagne px-3.5 py-2 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none">
                <span class="inline-flex items-center gap-1.5 font-semibold text-[#2B0D16]">
                    <span class="w-3 h-3 rounded-xs bg-[#F7EFE6] border border-[#C4A484]"></span> [L] Lista
                </span>
                <span class="inline-flex items-center gap-1.5 font-semibold text-[#2B0D16]">
                    <span class="w-3 h-3 rounded-xs bg-[#4A1926]"></span> [S] Sucia
                </span>
                <span class="inline-flex items-center gap-1.5 font-semibold text-[#2B0D16]">
                    <span class="w-3 h-3 rounded-xs bg-[#A66E3E]"></span> [P] En Proceso
                </span>
                <span class="inline-flex items-center gap-1.5 font-semibold text-[#2B0D16]">
                    <span class="w-3 h-3 rounded-xs bg-rose-800"></span> [A] Avería
                </span>
            </div>

            <!-- Botones de filtrado por planta -->
            <div class="flex items-center gap-1.5 text-[11px] shrink-0">
                <span class="font-bold text-stone-600 uppercase mr-1">Planta:</span>
                <button type="button" onclick="filterFloorMap('all')" id="flt-all" class="floor-btn btn-3d-bronze px-3.5 py-1.5 text-white font-bold rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none cursor-pointer">Todas</button>
                <button type="button" onclick="filterFloorMap('3')" id="flt-3" class="floor-btn px-3.5 py-1.5 recessed-3d-champagne text-[#2B0D16] font-bold rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none hover:bg-white cursor-pointer">P3</button>
                <button type="button" onclick="filterFloorMap('2')" id="flt-2" class="floor-btn px-3.5 py-1.5 recessed-3d-champagne text-[#2B0D16] font-bold rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none hover:bg-white cursor-pointer">P2</button>
                <button type="button" onclick="filterFloorMap('1')" id="flt-1" class="floor-btn px-3.5 py-1.5 recessed-3d-champagne text-[#2B0D16] font-bold rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none hover:bg-white cursor-pointer">P1</button>
            </div>
        </div>

        <!-- Rejillas de habitaciones por planta -->
        <div class="space-y-5">
            <!-- Planta 3 -->
            <div id="row-floor-3" class="recessed-3d-champagne p-4 rounded-tl-2xl rounded-br-2xl rounded-tr-none rounded-bl-none space-y-2.5">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-[#2B0D16] uppercase tracking-wider">Planta 3 — Suites &amp; Dobles Superiores</span>
                    <span class="text-[10px] text-stone-500 font-semibold">301 – 318 (18 hab.)</span>
                </div>
                <div class="grid grid-cols-4 sm:grid-cols-6 md:grid-cols-9 lg:grid-cols-18 gap-2" id="grid-p3"></div>
            </div>

            <!-- Planta 2 -->
            <div id="row-floor-2" class="recessed-3d-champagne p-4 rounded-tl-2xl rounded-br-2xl rounded-tr-none rounded-bl-none space-y-2.5">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-[#2B0D16] uppercase tracking-wider">Planta 2 — Dobles Estándar</span>
                    <span class="text-[10px] text-stone-500 font-semibold">201 – 218 (18 hab.)</span>
                </div>
                <div class="grid grid-cols-4 sm:grid-cols-6 md:grid-cols-9 lg:grid-cols-18 gap-2" id="grid-p2"></div>
            </div>

            <!-- Planta 1 -->
            <div id="row-floor-1" class="recessed-3d-champagne p-4 rounded-tl-2xl rounded-br-2xl rounded-tr-none rounded-bl-none space-y-2.5">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-[#2B0D16] uppercase tracking-wider">Planta 1 — Individuales y Familiares</span>
                    <span class="text-[10px] text-stone-500 font-semibold">101 – 116 (16 hab.)</span>
                </div>
                <div class="grid grid-cols-4 sm:grid-cols-8 lg:grid-cols-16 gap-2" id="grid-p1"></div>
            </div>
        </div>

        <p class="text-[11px] text-stone-500 italic flex items-center gap-1.5">
            <i class="bi bi-hand-index-thumb text-[#8C5C32]"></i>
            <span>Consejo operativo: Haz clic sobre cualquier habitación del mapa para alternar su estado visual (Lista → Sucia → En Proceso).</span>
        </p>
    </section>

</div>

<!-- LÓGICA JAVASCRIPT DE RENDERIZADO Y SINCRONIZACIÓN DE ESTADOS DEL MAPA -->
<script>
    let habitaciones = [];
    const cicloEstados = ['L', 'S', 'P', 'A'];

    /**
     * Inicializa el inventario físico de las 52 habitaciones distribuidas en 3 plantas.
     */
    function initRooms() {
        habitaciones = [];
        for (let i = 101; i <= 116; i++) {
            let estado = [102, 107, 114].includes(i) ? 'S' : ([105, 111].includes(i) ? 'P' : 'L');
            habitaciones.push({ id: i.toString(), floor: '1', status: estado });
        }
        for (let i = 201; i <= 218; i++) {
            let estado = [204, 209, 215].includes(i) ? 'S' : ([206, 212].includes(i) ? 'P' : (i === 207 ? 'A' : 'L'));
            habitaciones.push({ id: i.toString(), floor: '2', status: estado });
        }
        for (let i = 301; i <= 318; i++) {
            let estado = [305, 312, 317].includes(i) ? 'S' : (i === 308 ? 'P' : 'L');
            habitaciones.push({ id: i.toString(), floor: '3', status: estado });
        }
    }

    /**
     * Recalcula los contadores superiores según los estados actuales de cada habitación.
     */
    function actualizarContadoresMapa() {
        let listas = 0;
        let sucias = 0;
        let enProceso = 0;
        let averias = 0;

        habitaciones.forEach(hab => {
            if (hab.status === 'L') listas++;
            if (hab.status === 'S') sucias++;
            if (hab.status === 'P') enProceso++;
            if (hab.status === 'A') averias++;
        });

        document.getElementById('kpi-total-count').textContent = habitaciones.length;
        document.getElementById('kpi-clean-count').textContent = listas;
        document.getElementById('kpi-dirty-count').textContent = sucias;
        document.getElementById('kpi-process-count').textContent = enProceso;
        document.getElementById('kpi-maintenance-count').textContent = averias;
    }

    /**
     * Renderiza las celdas 3D de cada habitación en su planta correspondiente.
     */
    function renderMap() {
        const g1 = document.getElementById('grid-p1');
        const g2 = document.getElementById('grid-p2');
        const g3 = document.getElementById('grid-p3');
        g1.innerHTML = ''; 
        g2.innerHTML = ''; 
        g3.innerHTML = '';

        habitaciones.forEach(hab => {
            const celda = document.createElement('div');
            celda.className = `room-cell status-${hab.status}`;
            celda.title = `Habitación ${hab.id} (Planta ${hab.floor}) — Clic para cambiar estado`;
            celda.innerHTML = `<div class="font-bold text-xs">${hab.id}</div><div class="text-[9px] font-semibold opacity-85">[${hab.status}]</div>`;
            
            celda.onclick = () => {
                const idxActual = cicloEstados.indexOf(hab.status);
                hab.status = cicloEstados[(idxActual + 1) % cicloEstados.length];
                renderMap();
            };

            if (hab.floor === '1') g1.appendChild(celda);
            if (hab.floor === '2') g2.appendChild(celda);
            if (hab.floor === '3') g3.appendChild(celda);
        });

        actualizarContadoresMapa();
    }

    /**
     * Filtra la visualización de las plantas en el mapa y resalta el botón activo.
     */
    function filterFloorMap(planta) {
        document.getElementById('row-floor-1').style.display = (planta === 'all' || planta === '1') ? 'block' : 'none';
        document.getElementById('row-floor-2').style.display = (planta === 'all' || planta === '2') ? 'block' : 'none';
        document.getElementById('row-floor-3').style.display = (planta === 'all' || planta === '3') ? 'block' : 'none';

        document.querySelectorAll('.floor-btn').forEach(btn => {
            btn.className = 'floor-btn px-3.5 py-1.5 recessed-3d-champagne text-[#2B0D16] font-bold rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none hover:bg-white cursor-pointer';
        });
        const btnActivo = document.getElementById(`flt-${planta}`);
        if (btnActivo) {
            btnActivo.className = 'floor-btn btn-3d-bronze px-3.5 py-1.5 text-white font-bold rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none cursor-pointer';
        }
    }

    initRooms();
    renderMap();
</script>
@endsection