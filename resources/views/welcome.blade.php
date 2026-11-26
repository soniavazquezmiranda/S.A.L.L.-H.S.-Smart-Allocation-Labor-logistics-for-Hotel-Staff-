@extends('layouts.app') <!-- Hereda la cabecera, Tailwind y la barra lateral una sola vez -->

@section('content')
    <div class="max-w-4xl mx-auto space-y-8 py-12">
        
        <!-- BIENVENIDA PRINCIPAL (Estilo Corporativo Premium) -->
        <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 rounded-3xl p-8 text-white shadow-xl border border-slate-800 text-center relative overflow-hidden">
            <div class="w-16 h-12 bg-amber-500 rounded-xl flex items-center justify-center shadow-lg text-slate-950 font-black text-2xl mx-auto mb-4">
                S
            </div>
            <h1 class="text-3xl font-black tracking-tight text-white">S.A.L.L. HOTEL SYSTEM</h1>
            <p class="text-xs text-amber-400 mt-1 uppercase tracking-widest font-bold">Smart Allocation & Labor Logistics</p>
            
            <p class="text-sm text-slate-300 max-w-xl mx-auto mt-4 leading-relaxed">
                Bienvenido a la plataforma intermodular de gestión hotelera en tiempo real. Utiliza el menú lateral para navegar de forma fluida entre los diferentes departamentos operativos del complejo.
            </p>
        </div>

        <!-- TARJETAS DE ACCESO RÁPIDO PARA LAS SIMULACIONES EN EL AULA -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">
            
            <!-- Tarjeta Panel de Escritorio -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex flex-col justify-between gap-4">
                <div>
                    <span class="text-indigo-600 font-bold uppercase tracking-wider text-[10px] block mb-1">Entorno de Gestión</span>
                    <h3 class="text-base font-bold text-slate-900">Terminales de Escritorio</h3>
                    <p class="text-slate-500 mt-1 leading-relaxed">
                        Acceso unificado para los perfiles de Dirección (Julio), Recepción (LuzMila), Comercial (Loli) y Gobernanta (Sonia). Control analítico, Kpis y libro operativo de eventos.
                    </p>
                </div>
                <a href="{{ route('login') }}" class="w-full py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-center rounded-xl transition-all uppercase tracking-wider">
                    Abrir Login Premium
                </a>
            </div>

            <!-- Tarjeta Panel Móvil PDA -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex flex-col justify-between gap-4">
                <div>
                    <span class="text-amber-500 font-bold uppercase tracking-wider text-[10px] block mb-1">Entorno de Movilidad</span>
                    <h3 class="text-base font-bold text-slate-900">Terminal Operativo PDA</h3>
                    <p class="text-slate-500 mt-1 leading-relaxed">
                        Interfaz mobile-first adaptada para los teléfonos del staff de restauración (Maître Sergio) y servicios técnicos (Alonso). Gestión de fichajes obligatorios de jornada y alertas acústicas de tareas.
                    </p>
                </div>
                <a href="{{ route('pda.index') }}" class="w-full py-2.5 bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold text-center rounded-xl transition-all uppercase tracking-wider">
                    Simular Dispositivo PDA
                </a>
            </div>

        </div>

    </div>
@endsection

