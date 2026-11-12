@extends('layouts.app') <!-- Hereda la cabecera, Tailwind y la barra lateral una sola vez -->

@section('content')
<div class="w-full max-w-7xl mx-auto space-y-4 sm:space-y-6 px-1 sm:px-4">

    <!-- BARRA SUPERIOR (Cabecera Adaptativa de Recepción) -->
    <header class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 rounded-2xl p-4 sm:p-6 text-white shadow-xl border border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3 sm:gap-4 min-w-0">
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-amber-500 rounded-xl flex items-center justify-center shadow-lg text-slate-950 font-black text-xl sm:text-2xl shrink-0">
                S
            </div>
            <div class="min-w-0 flex-1">
                <h1 class="text-base sm:text-xl font-bold tracking-tight truncate">HOTEL GRAND CENTRAL — PANEL RECEPCIÓN</h1>
                <p class="text-[11px] sm:text-xs text-slate-300 mt-0.5 truncate">S.A.L.L. H.S. Core Frontdesk · {{ $totalRooms ?? 52 }} Habitaciones</p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-2 sm:gap-3 text-xs shrink-0 pt-2 sm:pt-0 border-t sm:border-t-0 border-slate-800/80">
            <span class="px-2.5 py-1 bg-slate-800 border border-slate-700 text-amber-400 font-semibold rounded-lg uppercase tracking-wider text-[10px] sm:text-xs">
                Rol: Recepción
            </span>
            <span class="text-slate-200 text-[11px] sm:text-xs truncate">Usuario: <strong class="text-white">{{ auth()->user()->name ?? 'Recepción' }}</strong></span>
            <!-- Indicador dinámico de estado en tiempo real (Efecto Radar/Ping) -->
            <span class="relative flex h-3 w-3 shrink-0" title="Sistema Online">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.9)]"></span>
            </span>
        </div>
    </header>

    <!-- MÉTRICAS DE CONEXIÓN CON CONTROLADOR (Grid Adaptativo Responsivo) -->
    <section class="grid grid-cols-1 min-[480px]:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 text-xs">
      
        <!-- Tarjeta 1: Total Habitaciones -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl shadow-sm border border-slate-200 flex flex-col justify-between min-w-0">
            <span class="text-[10px] sm:text-[11px] text-slate-500 uppercase font-bold tracking-wider truncate">Total Habitaciones</span>
            <span class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-2">{{ $totalRooms ?? 52 }}</span>
            <span class="text-[10px] sm:text-[11px] text-slate-400 border-t border-slate-100 pt-2 mt-2 truncate">Capacidad hotelera</span>
        </div>

        <!-- Tarjeta 2: Hab. Ocupadas -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl shadow-sm border border-slate-200 flex flex-col justify-between min-w-0">
            <span class="text-[10px] sm:text-[11px] text-slate-500 uppercase font-bold tracking-wider truncate">Hab. Ocupadas</span>
            <span class="text-2xl sm:text-3xl font-extrabold text-indigo-900 mt-2">{{ $occupiedRooms ?? 38 }}</span>
            <span class="text-[10px] sm:text-[11px] text-slate-400 border-t border-slate-100 pt-2 mt-2 truncate">Ocupación actual</span>
        </div>

        <!-- Tarjeta 3: Check-outs Pendientes -->
        <div class="bg-gradient-to-br from-amber-50 to-orange-50 p-4 sm:p-5 rounded-2xl shadow-sm border border-amber-200 flex flex-col justify-between min-w-0">
            <span class="text-[10px] sm:text-[11px] text-amber-900 uppercase font-bold tracking-wider truncate">Check-outs Pendientes</span>
            <span class="text-2xl sm:text-3xl font-extrabold text-amber-700 mt-2">{{ $pendingCheckouts ?? 9 }}</span>
            <span class="text-[10px] sm:text-[11px] text-amber-800 border-t border-amber-200/60 pt-2 mt-2 font-medium truncate">Prioridad jornada hoy</span>
        </div>

        <!-- Tarjeta 4: Habitaciones Sucias -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl shadow-sm border border-slate-200 flex flex-col justify-between min-w-0">
            <span class="text-[10px] sm:text-[11px] text-slate-500 uppercase font-bold tracking-wider truncate">Habitaciones Sucias</span>
            <span class="text-2xl sm:text-3xl font-extrabold text-rose-600 mt-2">{{ $dirtyRooms ?? 5 }}</span>
            <span class="text-[10px] sm:text-[11px] text-slate-400 border-t border-slate-100 pt-2 mt-2 truncate">En cola de limpieza PDA</span>
        </div>

    </section>

    <!-- BÚSQUEDA Y FILTROS ADAPTATIVOS -->
    <section class="bg-white p-3 sm:p-4 rounded-2xl shadow-sm border border-slate-200 flex flex-col md:flex-row md:items-center justify-between gap-3 text-xs">
        <div class="flex items-center gap-2 sm:gap-3 w-full md:w-auto flex-1 min-w-0">
            <span class="font-bold text-slate-500 uppercase tracking-wider text-[10px] sm:text-[11px] shrink-0">Buscar:</span>
            <input type="text" id="filter-search" oninput="applyFilters()" placeholder="Nº Habitación o huésped..." 
                   class="w-full bg-slate-50 border border-slate-300 px-3 py-1.5 sm:py-2 text-xs rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:bg-white transition-all">
        </div>

        <div class="flex flex-wrap items-center gap-2 sm:gap-3 text-[10px] sm:text-[11px] justify-between md:justify-end">
            <div class="flex items-center gap-1.5 flex-1 min-w-[130px] sm:flex-none">
                <span class="font-bold text-slate-500 uppercase tracking-wider shrink-0">Planta:</span>
                <select id="filter-floor" onchange="applyFilters()" class="w-full sm:w-auto bg-slate-50 border border-slate-300 px-2 sm:px-3 py-1.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500">
                    <option value="all">Todas</option>
                    <option value="1">Planta 1</option>
                    <option value="2">Planta 2</option>
                    <option value="3">Planta 3</option>
                </select>
            </div>

            <div class="flex items-center gap-1.5 flex-1 min-w-[140px] sm:flex-none">
                <span class="font-bold text-slate-500 uppercase tracking-wider shrink-0">Estado:</span>
                <select id="filter-status" onchange="applyFilters()" class="w-full sm:w-auto bg-slate-50 border border-slate-300 px-2 sm:px-3 py-1.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500">
                    <option value="all">Todos</option>
                    <option value="OCUPADA">Ocupada</option>
                    <option value="SUCIA">Sucia</option>
                    <option value="LISTA">Lista</option>
                </select>
            </div>
        </div>
    </section>

    <!-- TABLA DE HABITACIONES (Scroll interno flexible) -->
    <section class="bg-white rounded-2xl shadow-md border border-slate-200 overflow-hidden max-w-full">
        <div class="overflow-x-auto w-full">
            <table class="w-full text-left border-collapse text-xs min-w-[600px]">
                <thead class="bg-gradient-to-r from-slate-900 to-indigo-950 text-white uppercase text-[10px] sm:text-[11px] tracking-wider">
                    <tr>
                        <th class="p-3 sm:p-4 font-bold">Habitación</th>
                        <th class="p-3 sm:p-4 font-bold">Huésped Titular</th>
                        <th class="p-3 sm:p-4 font-bold">Régimen</th>
                        <th class="p-3 sm:p-4 font-bold">Estado Actual</th>
                        <th class="p-3 sm:p-4 font-bold text-right">Acción de Recepción</th>
                    </tr>
                </thead>
                <tbody id="rooms-tbody" class="divide-y divide-slate-100 text-xs">
                    @forelse($rooms ?? [] as $room)
                        <tr class="room-row hover:bg-slate-50 transition-colors" 
                            data-id="{{ $room->number ?? $room->id }}" 
                            data-guest="{{ strtolower($room->guest_name ?? '---') }}" 
                            data-floor="{{ $room->floor ?? '1' }}" 
                            data-status="{{ strtoupper($room->status) }}">
                            <td class="p-3 sm:p-4 font-bold text-slate-900 whitespace-nowrap">Hab. {{ $room->number ?? $room->id }} <span class="text-slate-400 font-normal">(P{{ $room->floor ?? '1' }})</span></td>
                            <td class="p-3 sm:p-4 font-medium text-slate-700 whitespace-nowrap">{{ $room->guest_name ?? '---' }}</td>
                            <td class="p-3 sm:p-4 text-slate-500 whitespace-nowrap">{{ $room->regime ?? 'Solo Alojamiento' }}</td>
                            <td class="p-3 sm:p-4 whitespace-nowrap">
                                @if(strtoupper($room->status) === 'OCUPADA' || strtoupper($room->status) === 'OCCUPIED')
                                    <span class="px-2 py-0.5 sm:px-2.5 sm:py-1 rounded-lg bg-indigo-50 border border-indigo-200 text-indigo-700 font-bold text-[10px]">OCUPADA</span>
                                @elseif(strtoupper($room->status) === 'SUCIA' || strtoupper($room->status) === 'CLEANING')
                                    <span class="px-2 py-0.5 sm:px-2.5 sm:py-1 rounded-lg bg-rose-50 border border-rose-200 text-rose-700 font-bold text-[10px]">SUCIA</span>
                                @else
                                    <span class="px-2 py-0.5 sm:px-2.5 sm:py-1 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 font-bold text-[10px]">LISTA</span>
                                @endif
                            </td>
                            <td class="p-3 sm:p-4 text-right whitespace-nowrap">
                                @if(strtoupper($room->status) === 'OCUPADA' || strtoupper($room->status) === 'OCCUPIED')
                                    <!-- Formulario de Check-out directo enviando ID de habitación -->
                                    <form action="{{ route('tasks.store') }}" method="POST" class="inline-block">
                                        @csrf
                                        <input type="hidden" name="room_id" value="{{ $room->id }}">
                                        <input type="hidden" name="title" value="Limpieza por Check-Out (Hab. {{ $room->number ?? $room->id }})">
                                        <input type="hidden" name="is_urgent" value="1">
                                        
                                        <button type="submit" class="px-2.5 py-1 sm:px-3 sm:py-1.5 bg-amber-500 hover:bg-amber-600 active:scale-95 text-slate-950 font-bold rounded-lg shadow-sm transition-all text-[10px] sm:text-[11px] flex items-center gap-1 ml-auto cursor-pointer">
                                            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" />
                                            </svg>
                                            <span>CHECK-OUT</span>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-slate-400 italic text-[11px]">Sin acciones</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-slate-400">No hay habitaciones registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

</div>

<!-- SCRIPT DE FILTRADO DINÁMICO EN TIEMPO REAL -->
<script>
    function applyFilters() {
        let search = document.getElementById('filter-search').value.toLowerCase();
        let floor = document.getElementById('filter-floor').value;
        let status = document.getElementById('filter-status').value;
        let rows = document.querySelectorAll('.room-row');

        rows.forEach(row => {
            let matchSearch = row.dataset.id.includes(search) || row.dataset.guest.includes(search);
            let matchFloor = floor === 'all' || row.dataset.floor === floor;
            let matchStatus = status === 'all' || row.dataset.status === status || (status === 'SUCIA' && row.dataset.status === 'CLEANING') || (status === 'OCUPADA' && row.dataset.status === 'OCCUPIED');

            if (matchSearch && matchFloor && matchStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>
@endsection