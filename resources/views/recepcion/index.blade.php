@extends('layouts.app')

@section('content')
<!-- Estilos locales para la variante estética Borgoña / Champagne con geometría asimétrica esculpida en 3D -->
<style>
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
    .card-3d-champagne:hover {
        transform: translateY(-2px);
        box-shadow: 
            0 16px 30px -6px rgba(43, 13, 22, 0.18),
            0 4px 10px -2px rgba(43, 13, 22, 0.10),
            inset 0 1px 0 rgba(255, 255, 255, 1);
    }

    /* Superficie cóncava (hundida) para filtros y buscador */
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
</style>

<div class="space-y-6">

    <!-- 1. BANNER PRINCIPAL EN BORGOÑA CON CURVATURA ASIMÉTRICA PRONUNCIADA Y MARCO INTERIOR -->
    <header class="banner-3d-burgundy rounded-tl-[2.25rem] rounded-br-[2.25rem] rounded-tr-none rounded-bl-none p-3 sm:p-4 text-white">
        <!-- Filete interior dorado-champagne que replica el corte asimétrico -->
        <div class="rounded-tl-[1.75rem] rounded-br-[1.75rem] rounded-tr-none rounded-bl-none border border-[#E6BE9A]/25 p-5 sm:p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="min-w-0">
                <div class="flex items-center gap-2 text-[11px] uppercase tracking-[0.24em] text-[#E6BE9A] font-bold mb-1.5">
                    <span>Frontdesk &amp; Operaciones</span>
                    <span>•</span>
                    <span>Gran Hotel 5★</span>
                </div>
                <h1 class="font-serif text-3xl sm:text-4xl font-bold text-[#FDF8F4] tracking-tight">
                    Hotel Grand Central <span class="italic font-semibold text-[#E6BE9A]">— Recepción</span>
                </h1>
                <p class="text-xs text-[#D9C4C9] mt-1.5">
                    Control diario de ocupación, salidas y estado de habitaciones ({{ $totalRooms ?? 52 }} unidades)
                </p>
            </div>

            <!-- Bloque de operador con cápsula asimétrica rebajada -->
            <div class="flex items-center gap-3 text-xs bg-[#140509]/70 border border-[#E6BE9A]/30 px-4 py-2.5 rounded-tl-2xl rounded-br-2xl rounded-tr-none rounded-bl-none shadow-inner shrink-0 whitespace-nowrap">
                <div class="text-left sm:text-right">
                    <span class="text-[#C7AEB5] block text-[10px] uppercase tracking-wider">Operador en turno</span>
                    <strong class="text-[#FDF8F4] text-xs">{{ auth()->user()->name ?? 'Recepción' }}</strong>
                </div>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-tl-lg rounded-br-lg rounded-tr-none rounded-bl-none bg-[#4A1926] border border-[#7A2C41] text-[#F5DEC9] font-semibold text-[11px]">
                    <span class="w-2 h-2 rounded-full bg-[#E6BE9A] animate-pulse"></span>
                    Online
                </span>
            </div>
        </div>
    </header>

    <!-- 2. TARJETAS KPI ESCULPIDAS (ESQUINAS 1 Y 3 MUY REDONDEADAS, 2 Y 4 EN ÁNGULO RECTO) -->
    <section class="grid grid-cols-1 min-[480px]:grid-cols-2 lg:grid-cols-4 gap-5 text-xs">
        
        <!-- KPI 1: Capacidad total -->
        <div class="card-3d-champagne p-5 rounded-tl-[1.75rem] rounded-br-[1.75rem] rounded-tr-none rounded-bl-none border-l-[5px] border-l-[#2B0D16] flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[11px] text-stone-600 uppercase font-bold tracking-wider">Total Habitaciones</span>
                <span class="w-8 h-8 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none bg-[#F3ECE6] border border-[#D6C7BC] flex items-center justify-center text-[#2B0D16]">
                    <i class="bi bi-building text-sm"></i>
                </span>
            </div>
            <div class="font-serif text-4xl font-bold text-[#2B0D16] my-2.5">{{ $totalRooms ?? 52 }}</div>
            <p class="text-[11px] text-stone-500">Capacidad total del complejo</p>
        </div>

        <!-- KPI 2: Habitaciones ocupadas -->
        <div class="card-3d-champagne p-5 rounded-tl-[1.75rem] rounded-br-[1.75rem] rounded-tr-none rounded-bl-none border-l-[5px] border-l-[#632234] flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[11px] text-stone-600 uppercase font-bold tracking-wider">Hab. Ocupadas</span>
                <span class="w-8 h-8 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none bg-[#F3ECE6] border border-[#D6C7BC] flex items-center justify-center text-[#632234]">
                    <i class="bi bi-person-check text-sm"></i>
                </span>
            </div>
            <div class="font-serif text-4xl font-bold text-[#4A1926] my-2.5">{{ $occupiedRooms ?? 38 }}</div>
            <p class="text-[11px] text-stone-500">Huéspedes alojados actualmente</p>
        </div>

        <!-- KPI 3: Check-outs pendientes (Destacado en bronce-champagne) -->
        <div class="card-3d-champagne p-5 rounded-tl-[1.75rem] rounded-br-[1.75rem] rounded-tr-none rounded-bl-none border-l-[5px] border-l-[#A87344] flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[11px] text-[#8C5C32] uppercase font-bold tracking-wider">Check-outs Hoy</span>
                <span class="w-8 h-8 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none bg-[#F7EFE6] border border-[#DEC7AF] flex items-center justify-center text-[#A87344]">
                    <i class="bi bi-door-open text-sm"></i>
                </span>
            </div>
            <div class="font-serif text-4xl font-bold text-[#9E6838] my-2.5">{{ $pendingCheckouts ?? 9 }}</div>
            <p class="text-[11px] text-[#8C5C32]/85 font-medium">Salidas previstas pendientes</p>
        </div>

        <!-- KPI 4: En cola de limpieza -->
        <div class="card-3d-champagne p-5 rounded-tl-[1.75rem] rounded-br-[1.75rem] rounded-tr-none rounded-bl-none border-l-[5px] border-l-rose-800 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[11px] text-stone-600 uppercase font-bold tracking-wider">Cola de Limpieza</span>
                <span class="w-8 h-8 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none bg-rose-50 border border-rose-200 flex items-center justify-center text-rose-800">
                    <i class="bi bi-stars text-sm"></i>
                </span>
            </div>
            <div class="font-serif text-4xl font-bold text-rose-800 my-2.5">{{ $dirtyRooms ?? 5 }}</div>
            <p class="text-[11px] text-stone-500">Asignadas a gobernanta / PDA</p>
        </div>
    </section>

    <!-- 3. PANEL DE BÚSQUEDA Y FILTROS CON CONTORNO ASIMÉTRICO Y CAMPOS CÓNCAVOS -->
    <section class="card-3d-champagne p-4 sm:p-5 rounded-tl-2xl rounded-br-2xl rounded-tr-none rounded-bl-none flex flex-col md:flex-row md:items-center justify-between gap-3 text-xs">
        <div class="flex items-center gap-3 flex-1 min-w-0">
            <i class="bi bi-search text-[#2B0D16] font-bold shrink-0"></i>
            <input type="text" id="filter-search" oninput="applyFilters()" placeholder="Buscar por número de habitación o nombre del huésped..." 
                   class="w-full recessed-3d-champagne px-4 py-2.5 text-xs text-stone-800 placeholder-stone-500 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none focus:outline-none focus:border-[#4A1926] focus:bg-white transition-all">
        </div>

        <div class="flex flex-wrap items-center gap-3 text-xs shrink-0">
            <div class="flex items-center gap-2">
                <span class="font-bold text-stone-700">Planta:</span>
                <select id="filter-floor" onchange="applyFilters()" class="recessed-3d-champagne px-3.5 py-2.5 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none text-stone-800 font-medium focus:outline-none focus:border-[#4A1926]">
                    <option value="all">Todas</option>
                    <option value="1">Planta 1</option>
                    <option value="2">Planta 2</option>
                    <option value="3">Planta 3</option>
                </select>
            </div>

            <div class="flex items-center gap-2">
                <span class="font-bold text-stone-700">Estado:</span>
                <select id="filter-status" onchange="applyFilters()" class="recessed-3d-champagne px-3.5 py-2.5 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none text-stone-800 font-medium focus:outline-none focus:border-[#4A1926]">
                    <option value="all">Todos</option>
                    <option value="OCUPADA">Ocupada</option>
                    <option value="SUCIA">Sucia</option>
                    <option value="LISTA">Lista</option>
                </select>
            </div>
        </div>
    </section>

    <!-- 4. TABLA DE HABITACIONES CON CONTORNO ESCULPIDO Y BOTONES 3D ASIMÉTRICOS -->
    <section class="card-3d-champagne rounded-tl-[2rem] rounded-br-[2rem] rounded-tr-none rounded-bl-none overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs min-w-[600px]">
                <thead class="bg-[#2B0D16] text-[#FDF8F4] uppercase text-[11px] tracking-wider border-b-2 border-[#120408]">
                    <tr>
                        <th class="p-4 pl-6 font-bold">Habitación</th>
                        <th class="p-4 font-bold">Huésped Titular</th>
                        <th class="p-4 font-bold">Régimen</th>
                        <th class="p-4 font-bold">Estado Actual</th>
                        <th class="p-4 pr-6 font-bold text-right">Operación</th>
                    </tr>
                </thead>
                <tbody id="rooms-tbody" class="divide-y divide-stone-200/80">
                    @forelse($rooms ?? [] as $room)
                        <tr class="room-row hover:bg-[#F3ECE6]/80 transition-colors" 
                            data-id="{{ $room->room_number ?? $room->number ?? $room->id }}" 
                            data-guest="{{ strtolower($room->guest_name ?? '---') }}" 
                            data-floor="{{ $room->floor ?? '1' }}" 
                            data-status="{{ strtoupper($room->status) }}">
                            <td class="p-4 pl-6 font-bold text-stone-900 whitespace-nowrap">
                                <span class="inline-block px-2.5 py-0.5 rounded-tl-lg rounded-br-lg rounded-tr-none rounded-bl-none bg-[#F3ECE6] border border-[#D6C7BC] text-[#2B0D16] mr-1.5">
                                    #{{ $room->room_number ?? $room->number ?? $room->id }}
                                </span>
                                <span class="text-stone-500 font-normal">Planta {{ $room->floor ?? '1' }}</span>
                            </td>
                            <td class="p-4 font-semibold text-stone-800 whitespace-nowrap">{{ $room->guest_name ?? '---' }}</td>
                            <td class="p-4 text-stone-600 whitespace-nowrap">{{ $room->regime ?? 'Solo Alojamiento' }}</td>
                            <td class="p-4 whitespace-nowrap">
                                @if(strtoupper($room->status) === 'OCUPADA' || strtoupper($room->status) === 'OCCUPIED')
                                    <span class="px-3 py-1 rounded-tl-lg rounded-br-lg rounded-tr-none rounded-bl-none bg-[#F3ECE6] border border-[#D6C7BC] text-[#4A1926] font-bold text-[10px]">OCUPADA</span>
                                @elseif(strtoupper($room->status) === 'SUCIA' || strtoupper($room->status) === 'CLEANING')
                                    <span class="px-3 py-1 rounded-tl-lg rounded-br-lg rounded-tr-none rounded-bl-none bg-rose-100 border border-rose-300 text-rose-900 font-bold text-[10px]">SUCIA</span>
                                @else
                                    <span class="px-3 py-1 rounded-tl-lg rounded-br-lg rounded-tr-none rounded-bl-none bg-[#F7EFE6] border border-[#DEC7AF] text-[#7D512B] font-bold text-[10px]">DISPONIBLE</span>
                                @endif
                            </td>
                            <td class="p-4 pr-6 text-right whitespace-nowrap">
                                @if(strtoupper($room->status) === 'OCUPADA' || strtoupper($room->status) === 'OCCUPIED')
                                    <form action="{{ route('tasks.store') }}" method="POST" class="inline-block">
                                        @csrf
                                        <input type="hidden" name="room_id" value="{{ $room->id }}">
                                        <input type="hidden" name="title" value="Limpieza por Check-Out (Hab. {{ $room->room_number ?? $room->number ?? $room->id }})">
                                        <input type="hidden" name="is_urgent" value="1">
                                        
                                        <button type="submit" class="btn-3d-bronze px-4 py-1.5 text-white font-bold rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none text-[11px] inline-flex items-center gap-1.5 cursor-pointer">
                                            <i class="bi bi-box-arrow-right"></i>
                                            <span>Registrar Check-Out</span>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-stone-400 italic text-[11px]">Sin acciones pendientes</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-stone-500">No hay habitaciones registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

</div>

<!-- LÓGICA JAVASCRIPT EN CLIENTE PARA FILTRADO INSTANTÁNEO -->
<script>
    /**
     * Filtra las filas de la tabla de habitaciones combinando búsqueda textual,
     * número de planta y estado operativo actual.
     */
    function applyFilters() {
        let busqueda = document.getElementById('filter-search').value.toLowerCase();
        let planta = document.getElementById('filter-floor').value;
        let estado = document.getElementById('filter-status').value;
        let filas = document.querySelectorAll('.room-row');

        filas.forEach(fila => {
            let coincideBusqueda = fila.dataset.id.toLowerCase().includes(busqueda) || fila.dataset.guest.includes(busqueda);
            let coincidePlanta = planta === 'all' || fila.dataset.floor === planta;
            let coincideEstado = estado === 'all' || fila.dataset.status === estado || (estado === 'SUCIA' && fila.dataset.status === 'CLEANING') || (estado === 'OCUPADA' && fila.dataset.status === 'OCCUPIED');

            fila.style.display = (coincideBusqueda && coincidePlanta && coincideEstado) ? '' : 'none';
        });
    }
</script>
@endsection