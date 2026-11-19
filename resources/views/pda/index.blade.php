@extends('layouts.app')

@section('content')
<style>
    /* Botón de salida con núcleo claro, halo luminoso en los bordes y sombra oscura bajo las letras */
    .boton-salida-estela {
        position: relative;
        background: radial-gradient(
            ellipse at center,
            #FFF8F0 0%,
            #F3E2D0 58%,
            #DFC2A5 100%
        );
        color: #240911;
        border: 1px solid rgba(255, 244, 232, 0.9);
        text-shadow:
            0 1px 2px rgba(25, 6, 12, 0.45),
            0 0 8px rgba(43, 13, 22, 0.25);
        box-shadow:
            0 0 18px rgba(245, 222, 201, 0.48),
            0 0 32px rgba(230, 190, 154, 0.24),
            inset 0 0 16px rgba(255, 255, 255, 0.85),
            inset 0 -3px 8px rgba(140, 92, 50, 0.35);
        transition: all 0.25s ease;
    }

    .boton-salida-estela:hover {
        background: radial-gradient(
            ellipse at center,
            #FFFFFF 0%,
            #F7E8D8 62%,
            #E7CCB0 100%
        );
        box-shadow:
            0 0 24px rgba(255, 236, 214, 0.72),
            0 0 40px rgba(230, 190, 154, 0.36),
            inset 0 0 20px rgba(255, 255, 255, 0.95),
            inset 0 -3px 8px rgba(140, 92, 50, 0.4);
        transform: translateY(-1px);
    }
</style>
<div class="max-w-lg mx-auto space-y-5 text-xs">

    <!-- 1. TARJETA DE IDENTIFICACIÓN DEL OPERARIO Y FICHAJE DE JORNADA EN 3D -->
    <section class="banner-3d-burgundy rounded-tl-[2rem] rounded-br-[2rem] rounded-tr-none rounded-bl-none p-3 text-white">
        <div class="rounded-tl-[1.5rem] rounded-br-[1.5rem] rounded-tr-none rounded-bl-none border border-[#E6BE9A]/25 p-5 space-y-5">
            
            <!-- Datos del operario e indicador de conexión -->
            <div class="flex items-start justify-between gap-3">
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-tl-2xl rounded-br-2xl rounded-tr-none rounded-bl-none btn-3d-bronze text-white font-serif font-bold text-xl flex items-center justify-center shrink-0">
                        <i class="bi bi-phone"></i>
                    </div>
                    <div>
                        <span class="text-[10px] uppercase tracking-[0.22em] text-[#E6BE9A] font-bold block">
                            Terminal Móvil PDA
                        </span>
                        <h1 class="font-serif text-2xl font-bold text-[#FDF8F4] leading-tight mt-0.5">
                            {{ Auth::user()->name ?? 'Operario' }}
                        </h1>
                        <p class="text-[11px] text-[#D9C4C9] mt-0.5">
                            Departamento: <strong class="text-[#FDF8F4]">{{ Auth::user()->role ?? 'Operativo' }}</strong>
                        </p>
                    </div>
                </div>

                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-tl-lg rounded-br-lg rounded-tr-none rounded-bl-none bg-[#4A1926] border border-[#7A2C41] text-[#F5DEC9] font-semibold text-[11px] shrink-0">
                    <span class="w-2 h-2 rounded-full bg-[#E6BE9A] animate-pulse"></span>
                    Online
                </span>
            </div>

            <!-- Mensajes de estado de fichaje o tareas -->
            @if(session('success'))
                <div class="p-3 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none bg-emerald-900/90 border border-emerald-400/30 text-emerald-100 text-[11px] font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="p-3 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none bg-rose-900/90 border border-rose-400/30 text-rose-100 text-[11px] font-semibold">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Botón táctil de entrada / salida de jornada -->
            <div class="pt-4 border-t border-[#E6BE9A]/20">
                @if(!($turnoActivo ?? false))
                    <form action="{{ route('pda.fichar') }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="btn-3d-bronze w-full py-3.5 px-4 text-white font-bold rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none text-xs uppercase tracking-wider flex items-center justify-center gap-2 cursor-pointer">
                            <i class="bi bi-clock text-sm"></i>
                            <span>Iniciar Jornada en Entrada</span>
                        </button>
                    </form>
               @else
                    <!-- Botón de salida con efecto luminoso en bordes y lectura nítida del texto -->
                    <form action="{{ route('pda.salir') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="boton-salida-estela w-full py-3.5 px-4 font-bold rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none text-xs uppercase tracking-wider flex items-center justify-center gap-2 cursor-pointer">
                            <i class="bi bi-box-arrow-right text-sm text-[#4A1926]"></i>
                            <span>Registrar Salida de Jornada</span>
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </section>

    <!-- 2. AVISOS PRIORITARIOS / INCIDENCIAS URGENTES -->
    @php
        $coleccionTareas = $tareas ?? collect();
        $tareasUrgentes = $coleccionTareas->filter(function ($item) {
            return (bool) ($item->is_urgent ?? false) || (($item->priority ?? '') === 'High');
        });
    @endphp

    @if($tareasUrgentes->count() > 0)
    <section class="space-y-3">
        <div class="flex items-center justify-between px-1">
            <span class="text-[11px] font-bold uppercase tracking-wider text-rose-700 flex items-center gap-1.5">
                <span class="w-2.5 h-2.5 rounded-full bg-rose-600 animate-ping"></span>
                Atención Prioritaria
            </span>
            <span class="px-2 py-0.5 rounded-tl-md rounded-br-md rounded-tr-none rounded-bl-none bg-rose-100 border border-rose-300 text-[11px] font-bold text-rose-800">
                {{ $tareasUrgentes->count() }} urgente(s)
            </span>
        </div>

        @foreach($tareasUrgentes as $urgente)
            <article class="card-3d-champagne rounded-tl-2xl rounded-br-2xl rounded-tr-none rounded-bl-none p-4 border-l-[5px] border-l-rose-700 bg-rose-50/35 space-y-1.5">
                <div class="flex items-center justify-between gap-2">
                    <span class="font-serif font-bold text-base text-[#2B0D16]">
                        Hab. {{ $urgente->room->room_number ?? $urgente->room->number ?? 'General' }}
                    </span>
                    <span class="px-2.5 py-0.5 rounded-tl-lg rounded-br-lg rounded-tr-none rounded-bl-none bg-rose-700 text-white text-[10px] font-bold uppercase tracking-wider shadow-xs">
                        Urgente
                    </span>
                </div>
                <p class="text-xs text-stone-700 leading-relaxed">
                    <strong>{{ $urgente->title }}:</strong> {{ $urgente->description }}
                </p>
            </article>
        @endforeach
    </section>
    @endif

    <!-- 3. LISTADO DE ÓRDENES DE TRABAJO ASIGNADAS AL OPERARIO -->
    <section class="card-3d-champagne rounded-tl-[2rem] rounded-br-[2rem] rounded-tr-none rounded-bl-none p-5 sm:p-6 space-y-4">
        <div class="flex items-center justify-between border-b border-stone-200 pb-3">
            <div>
                <h2 class="font-serif text-xl font-bold text-[#2B0D16]">Mis Tareas Asignadas</h2>
                <p class="text-[11px] text-stone-500">Órdenes operativas pendientes para el turno actual</p>
            </div>
            <span class="px-3 py-1 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none recessed-3d-champagne text-[#2B0D16] font-bold text-[11px]">
                {{ $coleccionTareas->count() }} tareas
            </span>
        </div>

        <div class="space-y-3">
            @forelse($coleccionTareas as $tarea)
                <article class="p-4 rounded-tl-2xl rounded-br-2xl rounded-tr-none rounded-bl-none recessed-3d-champagne space-y-3">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <span class="font-serif font-bold text-base text-[#2B0D16] block">
                                Hab. {{ $tarea->room->room_number ?? $tarea->room->number ?? 'General' }}
                            </span>
                            <span class="text-[11px] font-bold text-[#8C5C32]">
                                {{ $tarea->title }}
                            </span>
                        </div>
                        <span class="px-2.5 py-0.5 rounded-tl-lg rounded-br-lg rounded-tr-none rounded-bl-none bg-white border border-[#D6C7BC] text-[#2B0D16] font-bold text-[10px] uppercase tracking-wider shrink-0">
                            {{ $tarea->status }}
                        </span>
                    </div>

                    @if(!empty($tarea->description))
                        <p class="text-[11px] text-stone-600 leading-relaxed">
                            {{ $tarea->description }}
                        </p>
                    @endif

                    <!-- Botones táctiles de cambio de estado de la tarea -->
                    <div class="pt-2 border-t border-[#D6C7BC]/70">
                        @if($tarea->status === 'Pending')
                            <form action="{{ route('tasks.start', $tarea->id) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="btn-3d-burgundy w-full py-2.5 px-3 text-[#FDF8F4] font-bold rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none text-xs flex items-center justify-center gap-1.5 cursor-pointer">
                                    <i class="bi bi-play-fill text-sm text-[#E6BE9A]"></i>
                                    <span>Iniciar Tarea</span>
                                </button>
                            </form>
                        @else
                            <form action="{{ route('tasks.complete', $tarea->id) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="btn-3d-bronze w-full py-2.5 px-3 text-white font-bold rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none text-xs flex items-center justify-center gap-1.5 cursor-pointer">
                                    <i class="bi bi-check2-circle text-sm"></i>
                                    <span>Marcar como Finalizada</span>
                                </button>
                            </form>
                        @endif
                    </div>
                </article>
            @empty
                <div class="py-8 px-4 text-center rounded-tl-2xl rounded-br-2xl rounded-tr-none rounded-bl-none recessed-3d-champagne space-y-1.5">
                    <i class="bi bi-check2-circle text-2xl text-[#4A1926] block"></i>
                    <p class="font-bold text-[#2B0D16]">No tienes tareas asignadas hoy</p>
                    <p class="text-[11px] text-stone-500">Las nuevas incidencias o limpiezas aparecerán aquí automáticamente.</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- 4. HERRAMIENTA DE ESCÁNER QR DE SERVICIO -->
    <section class="card-3d-champagne rounded-tl-2xl rounded-br-2xl rounded-tr-none rounded-bl-none p-4 space-y-3">
        <button type="button" onclick="alternarEscanerQr()"
                class="btn-3d-burgundy w-full py-3 px-4 text-[#FDF8F4] font-bold rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none text-xs uppercase tracking-wider flex items-center justify-center gap-2 cursor-pointer">
            <i class="bi bi-qr-code-scan text-base text-[#E6BE9A]"></i>
            <span>Abrir Escáner QR de Servicio</span>
        </button>

        <div id="panel-escaner-qr" class="hidden p-3.5 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none recessed-3d-champagne text-[11px] text-stone-700 space-y-1">
            <div class="font-bold text-[#2B0D16]">Cámara / Lector QR listo</div>
            <p>Enfoca el código QR de la puerta o zona común para validar la presencia del operario en el turno.</p>
        </div>
    </section>

</div>

<script>
    /**
     * Alterna la visibilidad del panel informativo del lector QR en la PDA.
     */
    function alternarEscanerQr() {
        const panelQr = document.getElementById('panel-escaner-qr');
        if (panelQr) {
            panelQr.classList.toggle('hidden');
        }
    }
</script>
@endsection