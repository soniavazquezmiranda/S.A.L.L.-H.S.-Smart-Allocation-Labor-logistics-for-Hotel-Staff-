@extends('layouts.app') <!-- Hereda la cabecera, Tailwind y la barra lateral una sola vez -->

@section('content')
<div class="w-full max-w-7xl mx-auto space-y-4 sm:space-y-6 px-1 sm:px-4">

    <!-- CABECERA PRINCIPAL ADAPTATIVA (Panel Comercial) -->
    <header class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 rounded-2xl p-4 sm:p-6 text-white shadow-xl border border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3 sm:gap-4 min-w-0">
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-amber-500 rounded-xl flex items-center justify-center shadow-lg text-slate-950 font-black text-xl sm:text-2xl shrink-0">
                S
            </div>
            <div class="min-w-0 flex-1">
                <h1 class="text-base sm:text-xl font-bold tracking-tight truncate">HOTEL GRAND CENTRAL — PANEL COMERCIAL</h1>
                <p class="text-[11px] sm:text-xs text-slate-300 mt-0.5 truncate">Sales & Events Logistics · 3 Salones de Convenciones</p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-2 sm:gap-3 text-xs shrink-0 pt-2 sm:pt-0 border-t sm:border-t-0 border-slate-800/80">
            <span class="px-2.5 py-1 bg-slate-800 border border-slate-700 text-amber-400 font-semibold rounded-lg uppercase tracking-wider text-[10px] sm:text-xs">
                Rol: Comercial / Ventas
            </span>
            <span class="text-slate-200 text-[11px] sm:text-xs truncate">Usuario: <strong class="text-white">{{ auth()->user()->name ?? 'Ludmila V.' }}</strong></span>
            
            <!-- Indicador dinámico de estado en tiempo real -->
            <span class="relative flex h-3 w-3 shrink-0" title="Sistema Online">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.9)]"></span>
            </span>
        </div>
    </header>

    <!-- MÉTRICAS DE EVENTOS Y SALONES -->
    <section class="grid grid-cols-1 min-[480px]:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 text-xs">
        
        <!-- Tarjeta 1: Salones Totales -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl shadow-sm border border-slate-200 flex flex-col justify-between min-w-0">
            <span class="text-[10px] sm:text-[11px] text-slate-500 uppercase font-bold tracking-wider truncate">Salones Totales</span>
            <span class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-2">3</span>
            <span class="text-[10px] sm:text-[11px] text-slate-400 border-t border-slate-100 pt-2 mt-2 truncate">Capacidad: 225 pax</span>
        </div>

        <!-- Tarjeta 2: Eventos Activos Hoy -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl shadow-sm border border-slate-200 flex flex-col justify-between min-w-0">
            <span class="text-[10px] sm:text-[11px] text-slate-500 uppercase font-bold tracking-wider truncate">Eventos Activos Hoy</span>
            <span class="text-2xl sm:text-3xl font-extrabold text-indigo-900 mt-2">{{ count($events ?? []) ?: 2 }}</span>
            <span class="text-[10px] sm:text-[11px] text-slate-400 border-t border-slate-100 pt-2 mt-2 truncate">1 en curso · 1 tarde</span>
        </div>

        <!-- Tarjeta 3: Tareas PDA Generadas -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl shadow-sm border border-slate-200 flex flex-col justify-between min-w-0">
            <span class="text-[10px] sm:text-[11px] text-slate-500 uppercase font-bold tracking-wider truncate">Tareas PDA Generadas</span>
            <span class="text-2xl sm:text-3xl font-extrabold text-amber-600 mt-2">{{ (count($events ?? []) ?: 2) * 2 }}</span>
            <span class="text-[10px] sm:text-[11px] text-slate-400 border-t border-slate-100 pt-2 mt-2 truncate">Restauración + Zonas Nobles</span>
        </div>

        <!-- Tarjeta 4: Cumplimiento SLA -->
        <div class="bg-emerald-50 p-4 sm:p-5 rounded-2xl shadow-sm border border-emerald-200 flex flex-col justify-between min-w-0">
            <span class="text-[10px] sm:text-[11px] text-emerald-900 uppercase font-bold tracking-wider truncate">Cumplimiento SLA</span>
            <span class="text-2xl sm:text-3xl font-extrabold text-emerald-700 mt-2">98%</span>
            <span class="text-[10px] sm:text-[11px] text-emerald-800 border-t border-emerald-200/60 pt-2 mt-2 font-medium truncate">Sin retraso de montaje</span>
        </div>

    </section>

    <!-- FORMULARIO DE CONTRATACIÓN Y RESERVA DE EVENTOS -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <section class="lg:col-span-7 xl:col-span-6 bg-white p-4 sm:p-6 rounded-2xl shadow-md border border-slate-200 flex flex-col gap-4 text-xs">
            <div class="border-b border-slate-200 pb-3">
                <span class="text-[10px] uppercase font-bold text-amber-600 tracking-wider block">Nueva Contratación</span>
                <h2 class="text-base font-bold text-slate-900">Alta de Reserva de Salón / Evento</h2>
            </div>

            <form action="{{ route('comercial.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="is_urgent" value="1">

                <div>
                    <label for="room_id" class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Espacio / Salón Asignado *</label>
                    <select id="room_id" name="room_id" required class="w-full bg-slate-50 border border-slate-300 p-2.5 rounded-xl focus:ring-2 focus:ring-amber-500 text-xs">
                        <option value="Salón Mirador">Salón Mirador (Capacidad 120 pax · P3)</option>
                        <option value="Salón Noble">Salón Noble (Capacidad 80 pax · PB)</option>
                        <option value="Sala VIP Ejecutiva">Sala VIP Ejecutiva (Capacidad 25 pax · P1)</option>
                    </select>
                </div>

                <div>
                    <label for="client" class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Empresa / Huésped Titular *</label>
                    <input type="text" id="client" name="client" required placeholder="Ej. MedTech Congresos S.L." class="w-full bg-slate-50 border border-slate-300 p-2.5 rounded-xl focus:ring-2 focus:ring-amber-500 text-xs">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label for="date" class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Fecha *</label>
                        <input type="date" id="date" name="date" value="2026-10-22" required class="w-full bg-slate-50 border border-slate-300 p-2.5 rounded-xl text-xs">
                    </div>
                    <div>
                        <label for="pax" class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Asistentes (Pax) *</label>
                        <input type="number" id="pax" name="pax" value="45" min="1" max="200" required class="w-full bg-slate-50 border border-slate-300 p-2.5 rounded-xl text-xs">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label for="start_time" class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Hora Inicio *</label>
                        <input type="time" id="start_time" name="start_time" value="16:00" required class="w-full bg-slate-50 border border-slate-300 p-2.5 rounded-xl text-xs">
                    </div>
                    <div>
                        <label for="end_time" class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Hora Fin *</label>
                        <input type="time" id="end_time" name="end_time" value="19:30" required class="w-full bg-slate-50 border border-slate-300 p-2.5 rounded-xl text-xs">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label for="setup" class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Tipo de Montaje *</label>
                        <select id="setup" name="setup" required class="w-full bg-slate-50 border border-slate-300 p-2.5 rounded-xl text-xs">
                            <option value="Forma en U">Forma en U (Mesas + Sillas)</option>
                            <option value="Teatro">Formato Teatro (Solo Sillas)</option>
                            <option value="Escuela">Formato Escuela (Mesas corridas)</option>
                            <option value="Banquete">Banquete (Mesas redondas)</option>
                        </select>
                    </div>
                    <div>
                        <label for="catering" class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Catering *</label>
                        <select id="catering" name="catering" required class="w-full bg-slate-50 border border-slate-300 p-2.5 rounded-xl text-xs">
                            <option value="Coffee Break Continuo">Coffee Break Continuo</option>
                            <option value="Menú Ejecutivo">Menú Ejecutivo</option>
                            <option value="Buffet Libre Comedor">Buffet Libre Comedor</option>
                            <option value="Cóctel de Bienvenida">Cóctel de Bienvenida</option>
                        </select>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-3 bg-amber-500 hover:bg-amber-600 active:scale-95 text-slate-950 font-bold rounded-xl shadow-md transition-all text-xs uppercase tracking-wider flex items-center justify-center gap-2">
                        <i class="bi bi-plus-circle-fill text-sm"></i>
                        <span>Registrar Evento y Generar Tareas</span>
                    </button>
                </div>
            </form>
        </section>
    </div>

</div>
@endsection