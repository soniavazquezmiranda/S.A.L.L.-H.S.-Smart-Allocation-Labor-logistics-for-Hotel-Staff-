@extends('layouts.app') <!-- Hereda la cabecera, Tailwind y la barra lateral una sola vez -->

@section('content')
  <div class="max-w-7xl mx-auto space-y-6">

    <!-- HEADER (Navy Blue) -->
    <header class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 rounded-2xl p-6 text-white shadow-xl border border-slate-800 flex flex-wrap items-center justify-between gap-4">
      <div class="flex items-center gap-4">
        <div class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center shadow-lg text-slate-950 font-black text-2xl">
          S
        </div>
        <div>
          <h1 class="text-xl font-bold tracking-tight">HOTEL S.A.L.L. — CUADRO DE MANDOS GOBERNANTA</h1>
          <p class="text-xs text-slate-300 mt-0.5">S.A.L.L. H.S. Housekeeping & Management Dashboard</p>
        </div>
      </div>

      <div class="flex items-center gap-3 text-xs">
        <span class="px-3 py-1.5 bg-slate-800 border border-slate-700 text-amber-400 font-semibold rounded-lg uppercase tracking-wider">
          Rol: Gobernanta / Dirección
        </span>
        <span class="text-slate-200">Usuario: <strong class="text-white">{{ auth()->user()->name ?? 'Sonia' }}</strong></span>
        <div class="flex items-center gap-2 bg-emerald-950/80 border border-emerald-700 px-3 py-1 rounded-lg text-emerald-300 text-[11px] font-semibold">
          <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
          <span>PDA Reverb Sync</span>
        </div>
      </div>
    </header>

    <!-- KPIS -->
    <section class="grid grid-cols-2 md:grid-cols-4 gap-4 text-xs">
      <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 flex flex-col justify-between">
        <span class="text-[11px] text-slate-500 uppercase font-bold tracking-wider">Total Habitaciones</span>
        <span class="text-3xl font-extrabold text-slate-900 mt-2">52</span>
        <span class="text-[11px] text-slate-400 border-t border-slate-100 pt-2 mt-2">100% inventario físico</span>
      </div>

      <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 flex flex-col justify-between">
        <span class="text-[11px] text-slate-500 uppercase font-bold tracking-wider">% Ocupación Hoy</span>
        <span class="text-3xl font-extrabold text-indigo-900 mt-2">73.1%</span>
        <span class="text-[11px] text-slate-400 border-t border-slate-100 pt-2 mt-2">38 hab. ocupadas</span>
      </div>

      <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 flex flex-col justify-between">
        <span class="text-[11px] text-slate-500 uppercase font-bold tracking-wider">Limpias vs Sucias</span>
        <div class="flex items-baseline gap-2 mt-2">
          <span class="text-3xl font-extrabold text-emerald-600" id="kpi-clean-count">38</span>
          <span class="text-lg text-slate-300">/</span>
          <span class="text-3xl font-extrabold text-rose-600" id="kpi-dirty-count">9</span>
        </div>
        <span class="text-[11px] text-slate-400 border-t border-slate-100 pt-2 mt-2">[L] Listas vs [S] Check-out</span>
      </div>

      <div class="bg-emerald-50 p-5 rounded-2xl shadow-sm border border-emerald-200 flex flex-col justify-between">
        <span class="text-[11px] text-emerald-900 uppercase font-bold tracking-wider">Tiempo Medio Limpieza</span>
        <span class="text-3xl font-extrabold text-emerald-700 mt-2">21.4 min</span>
        <span class="text-[11px] text-emerald-800 border-t border-emerald-200/60 pt-2 mt-2 font-medium">✓ Cumple SLA (&lt;25 min)</span>
      </div>
    </section>

    <!-- MAPA VISUAL DEL HOTEL -->
    <section class="bg-white p-6 rounded-2xl shadow-md border border-slate-200 space-y-4 text-xs">
      <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 pb-3">
        <div>
          <span class="text-[10px] font-bold uppercase text-amber-600 tracking-wider block">Mapa Visual en Tiempo Real</span>
          <h2 class="text-base font-bold text-slate-900">Distribución por Plantas (52 Habitaciones)</h2>
        </div>

        <div class="flex items-center gap-2 text-[11px]">
          <span class="font-bold text-slate-500 uppercase">Ver:</span>
          <button onclick="filterFloorMap('all')" id="flt-all" class="px-3 py-1 bg-slate-900 text-amber-400 font-bold rounded-lg shadow-sm">Todas</button>
          <button onclick="filterFloorMap('3')" id="flt-3" class="px-3 py-1 bg-slate-100 text-slate-700 font-medium rounded-lg hover:bg-slate-200">P3</button>
          <button onclick="filterFloorMap('2')" id="flt-2" class="px-3 py-1 bg-slate-100 text-slate-700 font-medium rounded-lg hover:bg-slate-200">P2</button>
          <button onclick="filterFloorMap('1')" id="flt-1" class="px-3 py-1 bg-slate-100 text-slate-700 font-medium rounded-lg hover:bg-slate-200">P1</button>
        </div>
      </div>

      <div class="space-y-4">
        <div id="row-floor-3" class="space-y-2">
          <span class="text-[11px] font-bold text-slate-500 uppercase block">Planta 3 — Suites & Dobles Superiores</span>
          <div class="grid grid-cols-6 sm:grid-cols-9 md:grid-cols-18 gap-2" id="grid-p3"></div>
        </div>

        <div id="row-floor-2" class="space-y-2">
          <span class="text-[11px] font-bold text-slate-500 uppercase block">Planta 2 — Dobles Estándar</span>
          <div class="grid grid-cols-6 sm:grid-cols-9 md:grid-cols-18 gap-2" id="grid-p2"></div>
        </div>

        <div id="row-floor-1" class="space-y-2">
          <span class="text-[11px] font-bold text-slate-500 uppercase block">Planta 1 — Individuales y Familiares</span>
          <div class="grid grid-cols-4 sm:grid-cols-8 md:grid-cols-16 gap-2" id="grid-p1"></div>
        </div>
      </div>
    </section>

  </div>

  <script>
    let rooms = [];
    function initRooms() {
      rooms = [];
      for (let i = 101; i <= 116; i++) {
        let st = [102, 107, 114].includes(i) ? 'S' : ([105, 111].includes(i) ? 'P' : 'L');
        rooms.push({ id: i.toString(), floor: '1', status: st });
      }
      for (let i = 201; i <= 218; i++) {
        let st = [204, 209, 215].includes(i) ? 'S' : ([206, 212].includes(i) ? 'P' : (i === 207 ? 'A' : 'L'));
        rooms.push({ id: i.toString(), floor: '2', status: st });
      }
      for (let i = 301; i <= 318; i++) {
        let st = [305, 312, 317].includes(i) ? 'S' : (i === 308 ? 'P' : 'L');
        rooms.push({ id: i.toString(), floor: '3', status: st });
      }
    }

    function renderMap() {
      const g1 = document.getElementById('grid-p1');
      const g2 = document.getElementById('grid-p2');
      const g3 = document.getElementById('grid-p3');
      g1.innerHTML = ''; g2.innerHTML = ''; g3.innerHTML = '';

      rooms.forEach(r => {
        const el = document.createElement('div');
        el.className = `room-cell status-${r.status}`;
        el.innerHTML = `<div class="font-bold">${r.id}</div><div class="text-[9px] opacity-80">[${r.status}]</div>`;
        
        if (r.floor === '1') g1.appendChild(el);
        if (r.floor === '2') g2.appendChild(el);
        if (r.floor === '3') g3.appendChild(el);
      });
    }

    function filterFloorMap(floor) {
      document.getElementById('row-floor-1').style.display = (floor === 'all' || floor === '1') ? 'block' : 'none';
      document.getElementById('row-floor-2').style.display = (floor === 'all' || floor === '2') ? 'block' : 'none';
      document.getElementById('row-floor-3').style.display = (floor === 'all' || floor === '3') ? 'block' : 'none';
    }

    initRooms();
    renderMap();
  </script>
@endsection
