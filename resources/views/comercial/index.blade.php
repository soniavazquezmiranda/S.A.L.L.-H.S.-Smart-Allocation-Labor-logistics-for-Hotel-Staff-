@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <!-- 1. BANNER PRINCIPAL EN BORGOÑA PROFUNDO CON CURVATURA ASIMÉTRICA Y MARCO INTERIOR -->
    <header class="banner-3d-burgundy rounded-tl-[2.25rem] rounded-br-[2.25rem] rounded-tr-none rounded-bl-none p-3 sm:p-4 text-white">
        <div class="rounded-tl-[1.75rem] rounded-br-[1.75rem] rounded-tr-none rounded-bl-none border border-[#E6BE9A]/25 p-5 sm:p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="min-w-0">
                <div class="flex items-center gap-2 text-[11px] uppercase tracking-[0.24em] text-[#E6BE9A] font-bold mb-1.5">
                    <span>Sales &amp; Events Logistics</span>
                    <span>•</span>
                    <span>3 Salones de Convenciones</span>
                </div>
                <h1 class="font-serif text-3xl sm:text-4xl font-bold text-[#FDF8F4] tracking-tight">
                    Hotel Grand Central <span class="italic font-semibold text-[#E6BE9A]">— Comercial</span>
                </h1>
                <p class="text-xs text-[#D9C4C9] mt-1.5">
                    Contratación de salones corporativos, banquetes y generación automática de órdenes PDA
                </p>
            </div>

            <!-- Bloque de ejecutivo comercial con cápsula asimétrica rebajada -->
            <div class="flex items-center gap-3 text-xs bg-[#140509]/70 border border-[#E6BE9A]/30 px-4 py-2.5 rounded-tl-2xl rounded-br-2xl rounded-tr-none rounded-bl-none shadow-inner shrink-0 whitespace-nowrap">
                <div class="text-left sm:text-right">
                    <span class="text-[#C7AEB5] block text-[10px] uppercase tracking-wider">Ejecutivo Comercial</span>
                    <strong class="text-[#FDF8F4] text-xs">{{ auth()->user()->name ?? 'Ludmila V.' }}</strong>
                </div>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-tl-lg rounded-br-lg rounded-tr-none rounded-bl-none bg-[#4A1926] border border-[#7A2C41] text-[#F5DEC9] font-semibold text-[11px]">
                    <span class="w-2 h-2 rounded-full bg-[#E6BE9A] animate-pulse"></span>
                    Online
                </span>
            </div>
        </div>
    </header>

    <!-- 2. TARJETAS KPI ESCULPIDAS (ESQUINAS 1 Y 3 REDONDEADAS, 2 Y 4 EN ÁNGULO RECTO) -->
    <section class="grid grid-cols-1 min-[480px]:grid-cols-2 lg:grid-cols-4 gap-5 text-xs">
        
        <!-- KPI 1: Salones Totales -->
        <div class="card-3d-champagne p-5 rounded-tl-[1.75rem] rounded-br-[1.75rem] rounded-tr-none rounded-bl-none border-l-[5px] border-l-[#2B0D16] flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[11px] text-stone-600 uppercase font-bold tracking-wider">Salones Totales</span>
                <span class="w-8 h-8 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none bg-[#F3ECE6] border border-[#D6C7BC] flex items-center justify-center text-[#2B0D16]">
                    <i class="bi bi-door-closed text-sm"></i>
                </span>
            </div>
            <div class="font-serif text-4xl font-bold text-[#2B0D16] my-2.5">3</div>
            <p class="text-[11px] text-stone-500">Capacidad global: 225 pax</p>
        </div>

        <!-- KPI 2: Eventos Activos Hoy -->
        <div class="card-3d-champagne p-5 rounded-tl-[1.75rem] rounded-br-[1.75rem] rounded-tr-none rounded-bl-none border-l-[5px] border-l-[#632234] flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[11px] text-stone-600 uppercase font-bold tracking-wider">Eventos Hoy</span>
                <span class="w-8 h-8 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none bg-[#F3ECE6] border border-[#D6C7BC] flex items-center justify-center text-[#632234]">
                    <i class="bi bi-calendar-event text-sm"></i>
                </span>
            </div>
            <div class="font-serif text-4xl font-bold text-[#4A1926] my-2.5">{{ count($events ?? []) ?: 2 }}</div>
            <p class="text-[11px] text-stone-500">1 en curso · 1 turno tarde</p>
        </div>

        <!-- KPI 3: Tareas PDA Generadas -->
        <div class="card-3d-champagne p-5 rounded-tl-[1.75rem] rounded-br-[1.75rem] rounded-tr-none rounded-bl-none border-l-[5px] border-l-[#A87344] flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[11px] text-[#8C5C32] uppercase font-bold tracking-wider">Tareas PDA</span>
                <span class="w-8 h-8 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none bg-[#F7EFE6] border border-[#DEC7AF] flex items-center justify-center text-[#A87344]">
                    <i class="bi bi-phone-vibrate text-sm"></i>
                </span>
            </div>
            <div class="font-serif text-4xl font-bold text-[#9E6838] my-2.5">{{ (count($events ?? []) ?: 2) * 2 }}</div>
            <p class="text-[11px] text-[#8C5C32]/85 font-medium">Restauración + Zonas Nobles</p>
        </div>

        <!-- KPI 4: Cumplimiento SLA -->
        <div class="card-3d-champagne p-5 rounded-tl-[1.75rem] rounded-br-[1.75rem] rounded-tr-none rounded-bl-none border-l-[5px] border-l-emerald-800 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[11px] text-stone-600 uppercase font-bold tracking-wider">Cumplimiento SLA</span>
                <span class="w-8 h-8 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none bg-emerald-50 border border-emerald-200 flex items-center justify-center text-emerald-800">
                    <i class="bi bi-award text-sm"></i>
                </span>
            </div>
            <div class="font-serif text-4xl font-bold text-emerald-800 my-2.5">98%</div>
            <p class="text-[11px] text-stone-500">Sin retrasos de montaje</p>
        </div>

    </section>

    <!-- 3. FORMULARIO DE CONTRATACIÓN Y CATÁLOGO DE SALONES -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- COLUMNA IZQUIERDA: FORMULARIO DE ALTA DE EVENTO CON CAMPOS CÓNCAVOS 3D -->
        <section class="lg:col-span-7 card-3d-champagne p-6 sm:p-7 rounded-tl-[2rem] rounded-br-[2rem] rounded-tr-none rounded-bl-none border-t-[5px] border-t-[#2B0D16] flex flex-col gap-5 text-xs">
            <div class="border-b border-stone-200 pb-3.5 flex items-center justify-between">
                <div>
                    <span class="text-[10px] uppercase font-bold text-[#8C5C32] tracking-[0.2em] block">Nueva Contratación</span>
                    <h2 class="font-serif text-2xl font-bold text-[#2B0D16] mt-0.5">Alta de Reserva de Salón / Evento</h2>
                </div>
                <span class="w-9 h-9 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none bg-[#F3ECE6] border border-[#D6C7BC] flex items-center justify-center text-[#2B0D16]">
                    <i class="bi bi-journal-plus text-base"></i>
                </span>
            </div>

            <form action="{{ route('tasks.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="is_urgent" value="1">

                <!-- Selección de espacio o salón -->
                <div>
                    <label class="block text-[11px] font-bold text-[#2B0D16] uppercase tracking-wider mb-1.5">Espacio / Salón Asignado *</label>
                    <select name="room_id" required class="w-full recessed-3d-champagne px-3.5 py-2.5 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none text-stone-800 font-medium focus:outline-none focus:border-[#4A1926] focus:bg-white transition-all text-xs">
                        <option value="Salón Mirador">Salón Mirador (Capacidad 120 pax · Planta 3)</option>
                        <option value="Salón Noble">Salón Noble (Capacidad 80 pax · Planta Baja)</option>
                        <option value="Sala VIP Ejecutiva">Sala VIP Ejecutiva (Capacidad 25 pax · Planta 1)</option>
                    </select>
                </div>

                <!-- Empresa o huésped titular -->
                <div>
                    <label class="block text-[11px] font-bold text-[#2B0D16] uppercase tracking-wider mb-1.5">Empresa / Huésped Titular *</label>
                    <input type="text" name="client" required placeholder="Ej. MedTech Congresos S.L." 
                           class="w-full recessed-3d-champagne px-3.5 py-2.5 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none text-stone-800 placeholder-stone-400 focus:outline-none focus:border-[#4A1926] focus:bg-white transition-all text-xs">
                </div>

                <!-- Fecha y número de asistentes -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-[#2B0D16] uppercase tracking-wider mb-1.5">Fecha del Evento *</label>
                        <input type="date" name="date" value="2026-10-22" required 
                               class="w-full recessed-3d-champagne px-3.5 py-2.5 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none text-stone-800 focus:outline-none focus:border-[#4A1926] focus:bg-white transition-all text-xs">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-[#2B0D16] uppercase tracking-wider mb-1.5">Asistentes (Pax) *</label>
                        <input type="number" name="pax" value="45" min="1" max="200" required 
                               class="w-full recessed-3d-champagne px-3.5 py-2.5 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none text-stone-800 focus:outline-none focus:border-[#4A1926] focus:bg-white transition-all text-xs">
                    </div>
                </div>

                <!-- Horario de inicio y finalización -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-[#2B0D16] uppercase tracking-wider mb-1.5">Hora Inicio *</label>
                        <input type="time" name="start_time" value="16:00" required 
                               class="w-full recessed-3d-champagne px-3.5 py-2.5 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none text-stone-800 focus:outline-none focus:border-[#4A1926] focus:bg-white transition-all text-xs">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-[#2B0D16] uppercase tracking-wider mb-1.5">Hora Fin *</label>
                        <input type="time" name="end_time" value="19:30" required 
                               class="w-full recessed-3d-champagne px-3.5 py-2.5 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none text-stone-800 focus:outline-none focus:border-[#4A1926] focus:bg-white transition-all text-xs">
                    </div>
                </div>

                <!-- Tipo de montaje y servicio de catering -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-[#2B0D16] uppercase tracking-wider mb-1.5">Tipo de Montaje *</label>
                        <select name="setup" required class="w-full recessed-3d-champagne px-3.5 py-2.5 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none text-stone-800 font-medium focus:outline-none focus:border-[#4A1926] focus:bg-white transition-all text-xs">
                            <option value="Forma en U">Forma en U (Mesas + Sillas)</option>
                            <option value="Teatro">Formato Teatro (Solo Sillas)</option>
                            <option value="Escuela">Formato Escuela (Mesas corridas)</option>
                            <option value="Banquete">Banquete (Mesas redondas)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-[#2B0D16] uppercase tracking-wider mb-1.5">Servicio de Catering *</label>
                        <select name="catering" required class="w-full recessed-3d-champagne px-3.5 py-2.5 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none text-stone-800 font-medium focus:outline-none focus:border-[#4A1926] focus:bg-white transition-all text-xs">
                            <option value="Coffee Break Continuo">Coffee Break Continuo</option>
                            <option value="Menú Ejecutivo">Menú Ejecutivo</option>
                            <option value="Buffet Libre Comedor">Buffet Libre Comedor</option>
                            <option value="Cóctel de Bienvenida">Cóctel de Bienvenida</option>
                        </select>
                    </div>
                </div>

                <!-- Botón táctil en bronce 3D -->
                <div class="pt-3">
                    <button type="submit" class="btn-3d-bronze w-full py-3.5 px-5 text-white font-bold rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none text-xs uppercase tracking-wider flex items-center justify-center gap-2 cursor-pointer">
                        <i class="bi bi-plus-circle-fill text-sm"></i>
                        <span>Registrar Evento y Generar Tareas</span>
                    </button>
                </div>
            </form>
        </section>

        <!-- COLUMNA DERECHA: FICHA TÉCNICA DE SALONES DEL COMPLEJO -->
        <aside class="lg:col-span-5 space-y-4 text-xs">
            <div class="card-3d-champagne p-6 rounded-tl-[2rem] rounded-br-[2rem] rounded-tr-none rounded-bl-none border-t-[5px] border-t-[#A66E3E] space-y-4">
                <div class="border-b border-stone-200 pb-3">
                    <span class="text-[10px] uppercase font-bold text-[#8C5C32] tracking-[0.2em] block">Inventario MICE</span>
                    <h3 class="font-serif text-xl font-bold text-[#2B0D16] mt-0.5">Disponibilidad de Salones</h3>
                </div>

                <div class="space-y-3">
                    <!-- Salón 1 -->
                    <div class="recessed-3d-champagne p-3.5 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none space-y-1">
                        <div class="flex items-center justify-between">
                            <strong class="font-serif text-base text-[#2B0D16]">Salón Mirador</strong>
                            <span class="px-2 py-0.5 rounded-tl-md rounded-br-md rounded-tr-none rounded-bl-none bg-[#2B0D16] text-[#F5DEC9] text-[10px] font-bold">Planta 3</span>
                        </div>
                        <p class="text-[11px] text-stone-600">Aforo máximo: <strong>120 pax</strong> · Vistas panorámicas y luz natural.</p>
                    </div>

                    <!-- Salón 2 -->
                    <div class="recessed-3d-champagne p-3.5 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none space-y-1">
                        <div class="flex items-center justify-between">
                            <strong class="font-serif text-base text-[#2B0D16]">Salón Noble</strong>
                            <span class="px-2 py-0.5 rounded-tl-md rounded-br-md rounded-tr-none rounded-bl-none bg-[#4A1926] text-[#F5DEC9] text-[10px] font-bold">Planta Baja</span>
                        </div>
                        <p class="text-[11px] text-stone-600">Aforo máximo: <strong>80 pax</strong> · Acceso directo desde lobby principal.</p>
                    </div>

                    <!-- Salón 3 -->
                    <!-- Salón 3 -->
<div class="recessed-3d-champagne p-3.5 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none space-y-1">
    <div class="flex items-center justify-between">
        <strong class="font-serif text-base text-[#2B0D16]">Sala VIP Ejecutiva</strong>
        <span class="px-2 py-0.5 rounded-tl-md rounded-br-md rounded-tr-none rounded-bl-none bg-[#632234] text-[#F5DEC9] text-[10px] font-bold">Planta 1</span>
    </div>
    <p class="text-[11px] text-stone-600">Aforo máximo: <strong>25 pax</strong> · Mesa imperial de consejo y videoconferencia.</p>
</div>
                </div>

                <div class="pt-2 border-t border-stone-200/80 text-[11px] text-stone-500 flex items-start gap-2">
                    <i class="bi bi-info-circle text-[#8C5C32] mt-0.5"></i>
                    <span>Al registrar un evento se notifican automáticamente las órdenes de montaje y catering a los terminales PDA.</span>
                </div>
            </div>
        </aside>

    </div>

</div>
@endsection