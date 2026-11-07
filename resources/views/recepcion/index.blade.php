@extends('layouts.app') <!-- Hereda la cabecera, Tailwind y la barra lateral una sola vez -->

@section('content')
  <div class="max-w-7xl mx-auto space-y-6">

    <!-- BARRA SUPERIOR (Navy Blue Header) -->
    <header class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 rounded-2xl p-6 text-white shadow-xl border border-slate-800 flex flex-wrap items-center justify-between gap-4">
      <div class="flex items-center gap-4">
        <div class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center shadow-lg text-slate-950 font-black text-2xl">
          S
        </div>
        <div>
          <h1 class="text-xl font-bold tracking-tight">HOTEL GRAND CENTRAL — PANEL RECEPCIÓN</h1>
          <p class="text-xs text-slate-300 mt-0.5">S.A.L.L. H.S. Core Frontdesk · {{ $totalRooms ?? 52 }} Habitaciones</p>
        </div>
      </div>

      <div class="flex items-center gap-3 text-xs">
        <span class="px-3 py-1.5 bg-slate-800 border border-slate-700 text-amber-400 font-semibold rounded-lg uppercase tracking-wider">
          Rol: Recepción
        </span>
        <span class="text-slate-200">Usuario: <strong class="text-white">{{ auth()->user()->name ?? 'Sonia R.' }}</strong></span>
        <div class="w-3 h-3 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.8)]" title="Sistema Online"></div>
      </div>
    </header>

    <!-- METRICAS DE CONEXIÓN CON CONTROLADOR -->
    <section class="grid grid-cols-2 md:grid-cols-4 gap-4 text-xs">
      <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 flex flex-col justify-between">
        <span class="text-[11px] text-slate-500 uppercase font-bold tracking-wider">Total Habitaciones</span>
        <span class="text-3xl font-extrabold text-slate-900 mt-2">{{ $totalRooms ?? 52 }}</span>
        <span class="text-[11px] text-slate-400 border-t border-slate-100 pt-2 mt-2">Capacidad hotelera</span>
      </div>

      <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 flex flex-col justify-between">
        <span class="text-[11px] text-slate-500 uppercase font-bold tracking-wider">Hab. Ocupadas</span>
        <span class="text-3xl font-extrabold text-indigo-900 mt-2">{{ $occupiedRooms ?? 38 }}</span>
        <span class="text-[11px] text-slate-400 border-t border-slate-100 pt-2 mt-2">Ocupación actual</span>
      </div>

      <div class="bg-gradient-to-br from-amber-50 to-orange-50 p-5 rounded-2xl shadow-sm border border-amber-200 flex flex-col justify-between">
        <span class="text-[11px] text-amber-900 uppercase font-bold tracking-wider">Check-outs Pendientes</span>
        <span class="text-3xl font-extrabold text-amber-700 mt-2">{{ $pendingCheckouts ?? 9 }}</span>
        <span class="text-[11px] text-amber-800 border-t border-amber-200/60 pt-2 mt-2 font-medium">Prioridad jornada hoy</span>
      </div>

      <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 flex flex-col justify-between">
        <span class="text-[11px] text-slate-500 uppercase font-bold tracking-wider">Habitaciones Sucias</span>
        <span class="text-3xl font-extrabold text-rose-600 mt-2">{{ $dirtyRooms ?? 5 }}</span>
        <span class="text-[11px] text-slate-400 border-t border-slate-100 pt-2 mt-2">En cola de limpieza PDA</span>
      </div>
    </section>

    <!-- BÚSQUEDA Y FILTROS -->
    <section class="bg-white p-4 rounded-2xl shadow-sm border border-slate-200 flex flex-wrap items-center justify-between gap-4 text-xs">
      <div class="flex items-center gap-3 flex-1 min-w-[240px]">
        <span class="font-bold text-slate-500 uppercase tracking-wider text-[11px]">Buscar:</span>
        <input type="text" id="filter-search" oninput="applyFilters()" placeholder="Nº Habitación o huésped..." 
               class="flex-1 bg-slate-50 border border-slate-300 px-3 py-2 text-xs rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:bg-white transition-all">
      </div>

      <div class="flex flex-wrap items-center gap-3 text-[11px]">
        <span class="font-bold text-slate-500 uppercase tracking-wider">Planta:</span>
        <select id="filter-floor" onchange="applyFilters()" class="bg-slate-50 border border-slate-300 px-3 py-2 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500">
          <option value="all">Todas las plantas</option>
          <option value="1">Planta 1</option>
          <option value="2">Planta 2</option>
          <option value="3">Planta 3</option>
        </select>

        <span class="font-bold text-slate-500 uppercase tracking-wider ml-2">Estado:</span>
        <select id="filter-status" onchange="applyFilters()" class="bg-slate-50 border border-slate-300 px-3 py-2 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500">
          <option value="all">Todos los estados</option>
          <option value="OCUPADA">Ocupada</option>
          <option value="SUCIA">Sucia</option>
          <option value="LISTA">Lista</option>
        </select>
      </div>
    </section>

    <!-- TABLA DE HABITACIONES -->
    <section class="bg-white rounded-2xl shadow-md border border-slate-200 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-xs">
          <thead class="bg-gradient-to-r from-slate-900 to-indigo-950 text-white uppercase text-[11px] tracking-wider">
            <tr>
              <th class="p-4 font-bold">Habitación</th>
              <th class="p-4 font-bold">Huésped Titular</th>
              <th class="p-4 font-bold">Régimen</th>
              <th class="p-4 font-bold">Estado Actual</th>
              <th class="p-4 font-bold text-right">Acción de Recepción</th>
            </tr>
          </thead>
          <tbody id="rooms-tbody" class="divide-y divide-slate-100 text-xs">
            @forelse($rooms ?? [] as $room)
              <tr class="room-row hover:bg-slate-50 transition-colors" 
                  data-id="{{ $room->number ?? $room->id }}" 
                  data-guest="{{ strtolower($room->guest_name ?? '---') }}" 
                  data-floor="{{ $room->floor ?? '1' }}" 
                  data-status="{{ strtoupper($room->status) }}">
                <td class="p-4 font-bold text-slate-900">Hab. {{ $room->number ?? $room->id }} <span class="text-slate-400 font-normal">(P{{ $room->floor ?? '1' }})</span></td>
                <td class="p-4 font-medium text-slate-700">{{ $room->guest_name ?? '---' }}</td>
                <td class="p-4 text-slate-500">{{ $room->regime ?? 'Solo Alojamiento' }}</td>
                <td class="p-4">
                  @if(strtoupper($room->status) === 'OCUPADA' || strtoupper($room->status) === 'OCCUPIED')
                    <span class="px-2.5 py-1 rounded-lg bg-indigo-50 border border-indigo-200 text-indigo-700 font-bold text-[10px]">OCUPADA</span>
                  @elseif(strtoupper($room->status) === 'SUCIA' || strtoupper($room->status) === 'CLEANING')
                    <span class="px-2.5 py-1 rounded-lg bg-rose-50 border border-rose-200 text-rose-700 font-bold text-[10px]">SUCIA</span>
                  @else
                    <span class="px-2.5 py-1 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 font-bold text-[10px]">LISTA</span>
                  @endif
                </td>
                <td class="p-4 text-right text-slate-500">
                  <!-- Mantenemos las directivas lógicas intactas -->
                  ---
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
