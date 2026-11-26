@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 text-xs">

    <!-- CABECERA DEL PANEL MAESTRO DE ADMINISTRACIÓN -->
    <header class="bg-[#2B0D16] text-white p-6 rounded-2xl shadow-lg flex flex-wrap justify-between items-center gap-4">
        <div>
            <span class="text-[#E6BE9A] font-bold uppercase text-[10px]">Dirección General · Acceso Total</span>
            <h1 class="text-xl font-bold">PANEL DE ADMINISTRACIÓN — HOTEL S.A.L.L.</h1>
        </div>
        <!-- Accesos directos a todas las áreas del hotel -->
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('recepcion.index') }}" class="px-3 py-1.5 bg-white/10 rounded-lg hover:bg-white/20">Recepción</a>
            <a href="{{ route('gobernanta.index') }}" class="px-3 py-1.5 bg-white/10 rounded-lg hover:bg-white/20">Gobernanta</a>
            <a href="{{ route('comercial.index') }}" class="px-3 py-1.5 bg-white/10 rounded-lg hover:bg-white/20">Comercial</a>
            <a href="{{ route('pda.index') }}" class="px-3 py-1.5 btn-3d-bronze rounded-lg font-bold">Terminal PDA</a>
        </div>
    </header>

    <!--  INDICADORES GLOBALES (KPIS DE TODO EL HOTEL) -->
    <section class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-xl border">
            <span class="text-slate-500 font-bold uppercase">Ocupación</span>
            <p class="text-2xl font-extrabold mt-1">{{ $ocupadas }} / {{ $totalHabitaciones }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl border">
            <span class="text-slate-500 font-bold uppercase">Por Limpiar</span>
            <p class="text-2xl font-extrabold text-rose-600 mt-1">{{ $sucias }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl border">
            <span class="text-slate-500 font-bold uppercase">Eventos</span>
            <p class="text-2xl font-extrabold text-amber-600 mt-1">{{ $eventosActivos }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl border">
            <span class="text-slate-500 font-bold uppercase">Urgentes PDA</span>
            <p class="text-2xl font-extrabold text-emerald-600 mt-1">{{ $tareasUrgentes }}</p>
        </div>
    </section>

    <!--  RESUMEN DE DEPARTAMENTOS Y PLANTILLA ASIGNADA -->
    <section class="bg-white p-5 rounded-xl border space-y-3">
        <h2 class="text-sm font-bold uppercase text-slate-700">Departamentos</h2>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
            @foreach($departamentos as $dept)
                <div class="p-3 bg-slate-50 rounded-lg border">
                    <p class="font-bold text-[#2B0D16]">{{ $dept->name }}</p>
                    <p class="text-slate-500 mt-1">{{ $dept->users->count() }} empleados</p>
                </div>
            @endforeach
        </div>
    </section>

    <!-- HISTORIAL DE FICHAJES INDIVIDUALIZADO POR EMPLEADO -->
    <section class="bg-white p-5 rounded-xl border space-y-4">
        <h2 class="text-sm font-bold uppercase text-slate-700">Historial de Fichajes por Empleado</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($empleadosConFichajes as $emp)
                <div class="p-4 bg-slate-50 rounded-xl border space-y-2">
                    <div class="flex justify-between font-bold border-b pb-2">
                        <span>{{ $emp->name }} <small class="text-slate-500">({{ $emp->department->name ?? $emp->role }})</small></span>
                        <span class="text-[#2B0D16]">Total: {{ round($emp->shifts->sum('total_hours'), 2) }} h</span>
                    </div>

                    @forelse($emp->shifts as $turno)
                        <div class="flex justify-between bg-white px-2.5 py-1.5 rounded border text-[11px]">
                            <span>{{ \Carbon\Carbon::parse($turno->clock_in)->format('d/m/Y') }}</span>
                            <span>{{ \Carbon\Carbon::parse($turno->clock_in)->format('H:i') }} - {{ $turno->clock_out ? \Carbon\Carbon::parse($turno->clock_out)->format('H:i') : 'En turno' }}</span>
                            <span class="font-bold">{{ $turno->total_hours !== null ? $turno->total_hours . ' h' : '●' }}</span>
                        </div>
                    @empty
                        <p class="text-slate-400 italic">Sin fichajes registrados.</p>
                    @endforelse
                </div>
            @endforeach
        </div>
    </section>

</div>
@endsection
