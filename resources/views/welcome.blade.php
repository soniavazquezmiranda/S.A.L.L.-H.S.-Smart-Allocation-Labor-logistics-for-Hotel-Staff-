@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- 1. BANNER DE BIENVENIDA ESCULPIDO EN BORGOÑA CON MARCO INTERIOR -->
    <section class="banner-3d-burgundy rounded-tl-[2.5rem] rounded-br-[2.5rem] rounded-tr-none rounded-bl-none p-3 sm:p-4 text-center text-white">
        <div class="rounded-tl-[2rem] rounded-br-[2rem] rounded-tr-none rounded-bl-none border border-[#E6BE9A]/25 px-6 py-9 sm:py-12 space-y-4">
            <div class="w-14 h-14 rounded-tl-2xl rounded-br-2xl rounded-tr-none rounded-bl-none btn-3d-bronze text-white font-serif font-bold text-2xl flex items-center justify-center mx-auto">
                S
            </div>

            <div class="space-y-1.5">
                <p class="text-[11px] uppercase tracking-[0.26em] text-[#E6BE9A] font-bold">
                    Smart Allocation &amp; Labor Logistics
                </p>
                <h1 class="font-serif text-3xl sm:text-5xl font-bold text-[#FDF8F4] tracking-tight">
                    S.A.L.L. <span class="italic font-semibold text-[#E6BE9A]">Hotel System</span>
                </h1>
            </div>

            <p class="max-w-2xl mx-auto text-xs sm:text-sm text-[#D9C4C9] leading-relaxed">
                Plataforma intermodular de gestión hotelera en tiempo real para <strong class="text-[#FDF8F4]">Hotel Grand Central</strong>. 
                Utiliza la barra de navegación superior para desplazarte entre los departamentos operativos y terminales móviles del complejo.
            </p>
        </div>
    </section>

    <!-- 2. TARJETAS ASIMÉTRICAS DE ACCESO A LOS DOS ENTORNOS OPERATIVOS -->
    <section class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- TARJETA 1: ENTORNO DE GESTIÓN DE ESCRITORIO -->
        <article class="card-3d-champagne rounded-tl-[2rem] rounded-br-[2rem] rounded-tr-none rounded-bl-none p-6 sm:p-8 border-t-[5px] border-t-[#2B0D16] flex flex-col justify-between gap-6">
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold uppercase tracking-widest text-[#4A1926]">
                        Entorno de Gestión
                    </span>
                    <span class="w-9 h-9 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none bg-[#F3ECE6] border border-[#D6C7BC] flex items-center justify-center text-[#2B0D16]">
                        <i class="bi bi-display text-base"></i>
                    </span>
                </div>

                <h2 class="font-serif text-2xl font-bold text-[#2B0D16]">
                    Terminales de Escritorio
                </h2>

                <p class="text-xs text-stone-600 leading-relaxed">
                    Acceso unificado por roles corporativos para <strong>Administración</strong>, <strong>Recepción</strong>, <strong>Gobernanta</strong> y <strong>Departamento Comercial</strong>. Control analítico de ocupación, check-outs en tiempo real, asignación de tareas y libro operativo de eventos.
                </p>
            </div>

            <div>
                <a href="{{ route('login') }}" 
                   class="btn-3d-burgundy w-full py-3.5 px-5 text-[#FDF8F4] font-bold rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none text-xs uppercase tracking-wider flex items-center justify-center gap-2">
                    <i class="bi bi-shield-lock text-[#E6BE9A]"></i>
                    <span>Acceder al Panel de Control</span>
                </a>
            </div>
        </article>

        <!-- TARJETA 2: ENTORNO DE MOVILIDAD Y OPERACIONES EN CAMPO (PDA) -->
        <article class="card-3d-champagne rounded-tl-[2rem] rounded-br-[2rem] rounded-tr-none rounded-bl-none p-6 sm:p-8 border-t-[5px] border-t-[#A66E3E] flex flex-col justify-between gap-6">
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold uppercase tracking-widest text-[#8C5C32]">
                        Entorno de Movilidad
                    </span>
                    <span class="w-9 h-9 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none bg-[#F7EFE6] border border-[#DEC7AF] flex items-center justify-center text-[#A66E3E]">
                        <i class="bi bi-phone text-base"></i>
                    </span>
                </div>

                <h2 class="font-serif text-2xl font-bold text-[#2B0D16]">
                    Terminal Operativo PDA
                </h2>

                <p class="text-xs text-stone-600 leading-relaxed">
                    Interfaz mobile-first adaptada para los dispositivos del personal de <strong>Limpieza</strong>, <strong>Restauración (Maître)</strong> y <strong>Mantenimiento</strong>. Gestión de fichajes obligatorios de jornada, escáner QR y alertas urgentes de tareas.
                </p>
            </div>

            <div>
                <a href="{{ route('pda.index') }}" 
                   class="btn-3d-bronze w-full py-3.5 px-5 text-white font-bold rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none text-xs uppercase tracking-wider flex items-center justify-center gap-2">
                    <i class="bi bi-qr-code-scan"></i>
                    <span>Abrir Terminal Móvil PDA</span>
                </a>
            </div>
        </article>

    </section>

</div>
@endsection