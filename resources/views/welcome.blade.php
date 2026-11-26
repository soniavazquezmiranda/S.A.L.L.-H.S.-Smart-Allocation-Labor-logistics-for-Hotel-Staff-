@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto space-y-6 py-4 sm:py-8">
        
        <!-- 1. BANNER PRINCIPAL EN BORGOÑA PROFUNDO -->
        <div class="banner-3d-burgundy rounded-tl-[2.25rem] rounded-br-[2.25rem] rounded-tr-none rounded-bl-none p-8 sm:p-10 text-white text-center relative overflow-hidden">
            <div class="w-14 h-14 rounded-tl-2xl rounded-br-2xl rounded-tr-none rounded-bl-none btn-3d-bronze text-white font-serif font-bold text-3xl flex items-center justify-center mx-auto mb-4">
                S
            </div>
            
            <h1 class="font-serif text-3xl sm:text-4xl font-bold text-[#FDF8F4] tracking-tight">
                S.A.L.L. HOTEL SYSTEM
            </h1>
            <p class="text-[11px] uppercase tracking-[0.26em] text-[#E6BE9A] font-bold mt-1.5">
                Smart Allocation &amp; Labor Logistics
            </p>
            
            <p class="text-xs sm:text-sm text-[#D9C4C9] max-w-2xl mx-auto mt-4 leading-relaxed">
                Plataforma operativa unificada para la coordinación en tiempo real entre Recepción, Gobernanta, Dirección Comercial y los terminales móviles PDA del personal de servicio.
            </p>
        </div>

        <!-- 2. TARJETAS DE ACCESO POR ENTORNO OPERATIVO -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">
            
            <!-- Tarjeta 1: Terminales de Gestión (Escritorio) -->
            <div class="card-3d-champagne rounded-tl-[1.75rem] rounded-br-[1.75rem] rounded-tr-none rounded-bl-none p-6 sm:p-7 flex flex-col justify-between gap-5">
                <div class="space-y-2">
                    <span class="inline-block text-[10px] uppercase tracking-[0.2em] font-bold text-[#632234]">
                        Entorno de Gestión
                    </span>
                    <h2 class="font-serif text-2xl font-bold text-[#2B0D16]">
                        Terminales de Escritorio
                    </h2>
                    <p class="text-stone-600 leading-relaxed">
                        Acceso departamental para <strong>Administración</strong>, <strong>Recepción</strong>, <strong>Gobernanta</strong> y <strong>Comercial</strong>. Control de habitaciones, planificación de eventos y asignación de tareas.
                    </p>
                </div>

                @auth
                    @php
                        $dashboardRoute = match(auth()->user()->role) {
                            'Admin', 'Recepcion' => route('recepcion.index'),
                            'Gobernanta'         => route('gobernanta.index'),
                            'Comercial'          => route('comercial.index'),
                            default              => route('pda.index'),
                        };
                    @endphp
                    <a href="{{ $dashboardRoute }}" class="btn-3d-burgundy w-full py-3 px-4 text-[#FDF8F4] font-bold text-center rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none uppercase tracking-wider flex items-center justify-center gap-2">
                        <i class="bi bi-speedometer2"></i>
                        <span>Ir a mi Panel ({{ auth()->user()->role }})</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-3d-burgundy w-full py-3 px-4 text-[#FDF8F4] font-bold text-center rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none uppercase tracking-wider flex items-center justify-center gap-2">
                        <i class="bi bi-box-arrow-in-right"></i>
                        <span>Iniciar Sesión Corporativa</span>
                    </a>
                @endauth
            </div>

            <!-- Tarjeta 2: Terminal Operativo PDA (Movilidad) -->
            <div class="card-3d-champagne rounded-tl-[1.75rem] rounded-br-[1.75rem] rounded-tr-none rounded-bl-none p-6 sm:p-7 flex flex-col justify-between gap-5">
                <div class="space-y-2">
                    <span class="inline-block text-[10px] uppercase tracking-[0.2em] font-bold text-[#A66E3E]">
                        Entorno de Movilidad
                    </span>
                    <h2 class="font-serif text-2xl font-bold text-[#2B0D16]">
                        Terminal Operativo PDA
                    </h2>
                    <p class="text-stone-600 leading-relaxed">
                        Interfaz adaptada para los dispositivos móviles del personal operativo (rol <strong>Trabajador</strong>: limpieza, mantenimiento y restauración). Fichaje de jornada y gestión directa de cometidos asignados.
                    </p>
                </div>

                @if(auth()->check() && in_array(auth()->user()->role, ['Trabajador', 'Admin']))
                    <a href="{{ route('pda.index') }}" class="btn-3d-bronze w-full py-3 px-4 text-white font-bold text-center rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none uppercase tracking-wider flex items-center justify-center gap-2">
                        <i class="bi bi-phone"></i>
                        <span>Abrir Terminal PDA</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-3d-bronze w-full py-3 px-4 text-white font-bold text-center rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none uppercase tracking-wider flex items-center justify-center gap-2">
                        <i class="bi bi-phone"></i>
                        <span>Acceso Terminal PDA</span>
                    </a>
                @endif
            </div>

        </div>

    </div>
@endsection