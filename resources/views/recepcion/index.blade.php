<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>S.A.L.L. H.S. - Recepción</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', sans-serif; }
  </style>
</head>
<body class="bg-slate-100 min-h-screen p-4 md:p-8 text-slate-800">

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

    @if(session('success'))
      <div class="p-4 bg-emerald-950 border border-emerald-700 text-emerald-200 text-xs font-semibold rounded-xl flex items-center justify-between shadow-md">
        <span>✓ [ {{ session('success') }} ]</span>
        <span class="text-[10px] text-emerald-400 uppercase tracking-wider">Evento Notificado a PDA</span>
      </div>
    @endif

    <!-- TARJETAS DE KPIS -->
    <section class="grid grid-cols-2 md:grid-cols-4 gap-4 text-xs">
      <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 flex flex-col justify-between">
        <span class="text-[11px] text-slate-500 uppercase font-bold tracking-wider">Total Habitaciones</span>
        <span class="text-3xl font-extrabold text-slate-900 mt-2">{{ $totalRooms ?? 52 }}</span>
        <span class="text-[11px] text-slate-400 border-t border-slate-100 pt-2 mt-2">Capacidad hotelera</span>
      </div>

      <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 flex flex-col justify-between">
        <span class="text-[11px] text-slate-500 uppercase font-bold tracking-wider">Hab. Ocupadas</span>
        <span class="text-3xl font-extrabold text-indigo-900 mt-2">{{ $occupiedRooms ?? 38 }}</span>
        <span class="text-[11px] text-slate-400 border-t border-slate-100 pt-2 mt-2">73% ocupación actual</span>
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
                  @if(strtoupper($room->status) === 'OCUPADA')
                    <span class="px-2.5 py-1 rounded-lg bg-indigo-50 border border-indigo-200 text-indigo-700 font-bold text-[10px]">OCUPADA</span>
                  @elseif(strtoupper($room->status) === 'SUCIA')
                    <span class="px-2.5 py-1 rounded-lg bg-rose-50 border border-rose-200 text-rose-700 font-bold text-[10px]">SUCIA</span>
                  @else
                    <span class="px-2.5 py-1 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 font-bold text-[10px]">LISTA</span>
                  @endif
                </td>
                <td class="p-4 text-right">
                  @if(strtoupper($room->status) === 'OCUPADA')
                    <form action="{{ route('tasks.store') }}" method="POST" class="inline">
                      @csrf
                      <input type="hidden" name="room_id" value="{{ $room->id }}">
                      <input type="hidden" name="title" value="Limpieza por Check-out Hab {{ $room->number ?? $room->id }}">
                      <input type="hidden" name="is_urgent" value="1">
                      <button type="submit" class="py-2 px-4 bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-500 hover:to-amber-600 text-slate-950 font-bold text-[11px] rounded-xl shadow-sm hover:shadow transition-all uppercase tracking-wider ml-auto block">
                        ➔ Tramitar Check-Out
                      </button>
                    </form>
                  @elseif(strtoupper($room->status) === 'SUCIA')
                    <span class="text-slate-400 text-[11px] font-medium italic">En cola PDA Pisos</span>
                  @else
                    <span class="text-emerald-600 font-semibold text-[11px]">Disponible</span>
                  @endif
                </td>
              </tr>
            @empty
              <tr class="room-row hover:bg-slate-50 transition-colors" data-id="101" data-guest="lópez martí, elena" data-floor="1" data-status="OCUPADA">
                <td class="p-4 font-bold text-slate-900">Hab. 101 <span class="text-slate-400 font-normal">(P1)</span></td>
                <td class="p-4 font-medium text-slate-700">López Martí, Elena</td>
                <td class="p-4 text-slate-500">Media Pensión</td>
                <td class="p-4"><span class="px-2.5 py-1 rounded-lg bg-indigo-50 border border-indigo-200 text-indigo-700 font-bold text-[10px]">OCUPADA</span></td>
                <td class="p-4 text-right">
                  <button type="button" onclick="handleMockCheckout('101')" class="py-2 px-4 bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-500 hover:to-amber-600 text-slate-950 font-bold text-[11px] rounded-xl shadow-sm hover:shadow transition-all uppercase tracking-wider ml-auto block">
                    ➔ Tramitar Check-Out
                  </button>
                </td>
              </tr>
              <tr class="room-row hover:bg-slate-50 transition-colors" data-id="206" data-guest="---" data-floor="2" data-status="SUCIA">
                <td class="p-4 font-bold text-slate-900">Hab. 206 <span class="text-slate-400 font-normal">(P2)</span></td>
                <td class="p-4 font-medium text-slate-700">---</td>
                <td class="p-4 text-slate-500">---</td>
                <td class="p-4"><span class="px-2.5 py-1 rounded-lg bg-rose-50 border border-rose-200 text-rose-700 font-bold text-[10px]">SUCIA</span></td>
                <td class="p-4 text-right"><span class="text-slate-400 text-[11px] font-medium italic">En cola PDA Pisos</span></td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </section>

  </div>

  <script>
    function applyFilters() {
      const searchVal = document.getElementById('filter-search').value.toLowerCase();
      const floorVal = document.getElementById('filter-floor').value;
      const statusVal = document.getElementById('filter-status').value;
      const rows = document.querySelectorAll('.room-row');

      rows.forEach(r => {
        const id = r.getAttribute('data-id');
        const guest = r.getAttribute('data-guest');
        const floor = r.getAttribute('data-floor');
        const status = r.getAttribute('data-status');

        const matchesSearch = id.includes(searchVal) || guest.includes(searchVal);
        const matchesFloor = (floorVal === 'all') || (floor === floorVal);
        const matchesStatus = (statusVal === 'all') || (status === statusVal);

        r.style.display = (matchesSearch && matchesFloor && matchesStatus) ? '' : 'none';
      });
    }

    function handleMockCheckout(roomId) {
      alert(`Check-out de Habitación ${roomId} tramitado correctamente. Notificación emitida a la PDA de pisos.`);
    }
  </script>
</body>
</html>