@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto space-y-4 text-xs">

    <!-- CABECERA CON DATOS REALES DE USER -->
    <header class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200 flex flex-col gap-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-slate-900 text-amber-400 font-bold flex items-center justify-center text-sm shadow-sm shrink-0">
                    <i class="bi bi-phone-fill"></i>
                </div>
                <div>
                    <h1 class="text-xs font-extrabold uppercase tracking-wider text-slate-900">PDA: OPERARIO</h1>
                    <p class="text-[11px] text-slate-500 font-medium">{{ Auth::user()->name ?? 'Operario' }} · {{ Auth::user()->role ?? 'PDA' }}</p>
                </div>
            </div>

            <!-- Indicador de estado ONLINE en tiempo real -->
            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full text-[10px] font-bold shadow-sm">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                <span>ONLINE</span>
            </div>
        </div>

        <!-- BOTÓN DE FICHAJE INTELIGENTE EN ESPAÑOL -->
        @if(!($turnoActivo ?? false))
        <form action="{{ route('pda.fichar') }}" method="POST" class="pt-1">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 px-4 bg-emerald-600 hover:bg-emerald-700 active:scale-[0.98] text-white font-bold rounded-xl shadow-md transition-all cursor-pointer">
                <i class="bi bi-clock-fill text-base"></i>
                <span>INICIAR JORNADA EN ENTRADA</span>
            </button>
        </form>
        @else
        <form action="{{ route('pda.salir') }}" method="POST" class="pt-1">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 px-4 bg-rose-600 hover:bg-rose-700 active:scale-[0.98] text-white font-bold rounded-xl shadow-md transition-all cursor-pointer">
                <i class="bi bi-box-arrow-right text-base"></i>
                <span>REGISTRAR SALIDA DE JORNADA</span>
            </button>
        </form>
        @endif
    </header>

    <!-- ALERTAS URGENTES (TASKS DONDE IS_URGENT = 1) -->
    @foreach(($tareas ?? collect())->where('is_urgent', 1) as $urgente)
    <section class="bg-rose-50 border-2 border-rose-500 rounded-2xl p-4 shadow-sm flex flex-col gap-2 relative overflow-hidden">
        <div class="flex items-center justify-between">
            <span class="text-[10px] font-black uppercase text-rose-900 flex items-center gap-1.5">
                <span class="w-2.5 h-2.5 rounded-full bg-rose-600 animate-ping"></span>
                ¡AVISO URGENTE!
            </span>
            <span class="text-[9px] px-2 py-0.5 font-extrabold bg-rose-600 text-white rounded-full uppercase tracking-wider shadow-sm">URGENTE</span>
        </div>

        <div class="bg-white border border-rose-200 rounded-xl p-3 text-xs shadow-xs">
            <p class="font-bold text-slate-900 text-sm">Habitación: {{ $urgente->room->room_number ?? 'General' }}</p>
            <p class="text-[11px] text-slate-600 mt-1"><strong>{{ $urgente->title }}:</strong> {{ $urgente->description }}</p>
        </div>
    </section>
    @endforeach

    <!-- LISTADO DE TAREAS DESDE LA BASE DE DATOS (TABLE: TASKS) -->
    <section class="flex flex-col gap-3">
        <div class="flex justify-between items-center text-xs font-bold border-b border-slate-200 pb-2 px-1">
            <span class="uppercase tracking-wider text-slate-700">MIS TAREAS ASIGNADAS</span>
            <span class="text-[10px] bg-slate-200 text-slate-700 px-2 py-0.5 rounded-full font-bold">{{ count($tareas ?? []) }} tareas</span>
        </div>

        @forelse($tareas ?? [] as $tarea)
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200 flex flex-col gap-2">
            <div class="flex justify-between items-start">
                <span class="font-bold text-sm text-slate-900">Hab. {{ $tarea->room->room_number ?? 'General' }}</span>
                <span class="text-[10px] px-2 py-0.5 rounded-lg bg-slate-900 text-amber-400 font-bold uppercase tracking-wider">
                    {{ $tarea->status }}
                </span>
            </div>
            <p class="text-[11px] text-slate-600"><strong>{{ $tarea->title }}:</strong> {{ $tarea->description }}</p>

            <div class="flex gap-2 pt-2 border-t border-slate-100">
                @if($tarea->status === 'Pending')
                <form action="{{ route('tasks.start', $tarea->id) }}" method="POST" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full py-2 bg-slate-900 hover:bg-slate-800 text-amber-400 font-bold rounded-xl text-xs flex items-center justify-center gap-1 transition-all cursor-pointer">
                        <i class="bi bi-play-fill text-sm"></i> Iniciar
                    </button>
                </form>
                @else
                <form action="{{ route('tasks.complete', $tarea->id) }}" method="POST" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs flex items-center justify-center gap-1 transition-all cursor-pointer">
                        <i class="bi bi-check-lg text-sm"></i> Finalizar
                    </button>
                </form>
                @endif
            </div>
        </div>
        @empty
        <div class="bg-white rounded-2xl p-6 text-center border border-slate-200 text-slate-400 text-xs">
            <i class="bi bi-check2-circle text-2xl text-emerald-500 block mb-1"></i>
            No tienes tareas asignadas hoy.
        </div>
        @endforelse
    </section>

    <!-- ESCÁNER QR -->
    <section class="pt-2">
        <button type="button" class="w-full flex items-center justify-center gap-2 py-3.5 px-4 bg-slate-900 hover:bg-slate-800 active:scale-[0.98] text-amber-400 border border-amber-500/30 font-bold rounded-2xl shadow-md transition-all cursor-pointer">
            <i class="bi bi-qr-code-scan text-lg"></i>
            <span>ABRIR ESCÁNER QR BUFFET</span>
        </button>
    </section>

</div>
@endsection