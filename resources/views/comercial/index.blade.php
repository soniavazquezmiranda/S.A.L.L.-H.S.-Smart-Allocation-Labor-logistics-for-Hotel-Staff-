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
          <h1 class="text-xl font-bold tracking-tight">HOTEL GRAND CENTRAL — PANEL COMERCIAL</h1>
          <p class="text-xs text-slate-300 mt-0.5">Sales & Events Logistics · 3 Salones de Convenciones</p>
        </div>
      </div>

      <div class="flex items-center gap-3 text-xs">
        <span class="px-3 py-1.5 bg-slate-800 border border-slate-700 text-amber-400 font-semibold rounded-lg uppercase tracking-wider">
          Rol: Comercial / Ventas
        </span>
        <span class="text-slate-200">Usuario: <strong class="text-white">{{ auth()->user()->name ?? 'Ludmila V.' }}</strong></span>
        
        <form action="{{ route('login') }}" method="GET" class="inline">
          <button type="submit" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 border border-slate-700 text-white font-bold rounded-lg uppercase text-[10px] tracking-wider transition-all">
            Salir
          </button>
        </form>
      </div>
    </header>

    <!-- METRICAS -->
    <section class="grid grid-cols-2 md:grid-cols-4 gap-4 text-xs">
      <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 flex flex-col justify-between">
        <span class="text-[11px] text-slate-500 uppercase font-bold tracking-wider">Salones Totales</span>
        <span class="text-3xl font-extrabold text-slate-900 mt-2">3</span>
        <span class="text-[11px] text-slate-400 border-t border-slate-100 pt-2 mt-2">Capacidad: 225 pax</span>
      </div>

      <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 flex flex-col justify-between">
        <span class="text-[11px] text-slate-500 uppercase font-bold tracking-wider">Eventos Activos Hoy</span>
        <span class="text-3xl font-extrabold text-indigo-900 mt-2">{{ count($events ?? []) ?: 2 }}</span>
        <span class="text-[11px] text-slate-400 border-t border-slate-100 pt-2 mt-2">1 en curso · 1 tarde</span>
      </div>

      <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 flex flex-col justify-between">
        <span class="text-[11px] text-slate-500 uppercase font-bold tracking-wider">Tareas PDA Generadas</span>
        <span class="text-3xl font-extrabold text-amber-600 mt-2">{{ (count($events ?? []) ?: 2) * 2 }}</span>
        <span class="text-[11px] text-slate-400 border-t border-slate-100 pt-2 mt-2">Restauración + Zonas Nobles</span>
      </div>

      <div class="bg-emerald-50 p-5 rounded-2xl shadow-sm border border-emerald-200 flex flex-col justify-between">
        <span class="text-[11px] text-emerald-900 uppercase font-bold tracking-wider">Cumplimiento SLA</span>
        <span class="text-3xl font-extrabold text-emerald-700 mt-2">98%</span>
        <span class="text-[11px] text-emerald-800 border-t border-emerald-200/60 pt-2 mt-2 font-medium">Sin retraso de montaje</span>
      </div>
    </section>

    <!-- FORMULARIO Y TABLA -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

      <!-- FORMULARIO DE CONTRATACIÓN -->
      <section class="lg:col-span-5 bg-white p-6 rounded-2xl shadow-md border border-slate-200 flex flex-col gap-4 text-xs">
        <div class="border-b border-slate-200 pb-3">
          <span class="text-[10px] uppercase font-bold text-amber-600 tracking-wider block">Nueva Contratación</span>
          <h2 class="text-base font-bold text-slate-900">Alta de Reserva de Salón / Evento</h2>
        </div>

        <form action="{{ route('tasks.store') }}" method="POST" class="space-y-4">
          @csrf
          <input type="hidden" name="is_urgent" value="1">

          <div>
            <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Espacio / Salón Asignado *</label>
            <select name="room_id" required class="w-full bg-slate-50 border border-slate-300 p-2.5 rounded-xl focus:ring-2 focus:ring-amber-500 text-xs">
              <option value="Salón Mirador">Salón Mirador (Capacidad 120 pax · P3)</option>
              <option value="Salón Noble">Salón Noble (Capacidad 80 pax · PB)</option>
              <option value="Sala VIP Executiva">Sala VIP Ejecutiva (Capacidad 25 pax · P1)</option>
            </select>
          </div>

          <div>
            <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Empresa / Huésped Titular *</label>
            <input type="text" name="client" required placeholder="Ej. MedTech Congresos S.L." class="w-full bg-slate-50 border border-slate-300 p-2.5 rounded-xl focus:ring-2 focus:ring-amber-500 text-xs">
          </div>

          <div class="grid grid-cols-2 gap-3">
            <div>
              <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Fecha *</label>
              <input type="date" name="date" value="2026-10-22" required class="w-full bg-slate-50 border border-slate-300 p-2.5 rounded-xl text-xs">
            </div>
            <div>
              <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Asistentes (Pax) *</label>
              <input type="number" name="pax" value="45" min="1" max="200" required class="w-full bg-slate-50 border border-slate-300 p-2.5 rounded-xl text-xs">
            </div>
          </div>

          <div class="grid grid-cols-2 gap-3">
            <div>
              <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Hora Inicio *</label>
              <input type="time" name="start_time" value="16:00" required class="w-full bg-slate-50 border border-slate-300 p-2.5 rounded-xl text-xs">
            </div>
            <div>
              <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Hora Fin *</label>
              <input type="time" name="end_time" value="19:30" required class="w-full bg-slate-50 border border-slate-300 p-2.5 rounded-xl text-xs">
            </div>
          </div>

          <div class="grid grid-cols-2 gap-3">
            <div>
              <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Tipo de Montaje *</label>
              <select name="setup" required class="w-full bg-slate-50 border border-slate-300 p-2.5 rounded-xl text-xs">
                <option value="Forma en U">Forma en U (Mesas + Sillas)</option>
                <option value="Teatro">Formato Teatro (Solo Sillas)</option>
                <option value="Escuela">Formato Escuela (Mesas corridas)</option>
                <option value="Banquete">Banquete (Mesas redondas)</option>
              </select>
            </div>
            <div>
              <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Catering *</label>
              <select name="catering" required class="w-full bg-slate-50 border border-slate-300 p-2.5 rounded-xl text-xs">
                <option value="Coffee Break Continuo">Coffee Break Continuo</option>
                <option value="Menú Ejecutivo">Menú Ejecutivo</option>
                <option value="Buffet Libre Comedor">Buffet Libre Comedor</option>
                <option value="Cóctel de Bienvenida">Cóctel de Bienvenida</option>
              </select>
            </div>
          </div>
        </form>
      </section>

    </div>
  </div>
@endsection