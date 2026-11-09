@extends('layouts.app') <!-- Hereda la cabecera, Tailwind y el envoltorio una sola vez -->

@section('content')
<!-- CABECERA CON DATOS REALES DE USER -->
<header class="border-b-2 border-zinc-900 pb-3 flex flex-col gap-2">
  <div class="flex items-center justify-between">
    <div class="flex items-center gap-2">
      <div class="w-8 h-8 wire-box placeholder-x shrink-0"></div>
      <div>
        <h1 class="text-sm font-bold uppercase leading-none">PDA: OPERARIO</h1>
        <!-- Nombre de usuario real de Laravel -->
        <p class="text-[11px] text-zinc-500">{{ Auth::user()->name }} · {{ Auth::user()->role }}</p>
      </div>
    </div>
    <!-- Indicador de estado ONLINE en tiempo real con animación de pulso -->
    <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-100 text-emerald-800 border border-emerald-300 rounded-full text-xs font-bold shadow-sm">
      <!-- Icono de punto dinámico con efecto radar (ping) -->
      <span class="relative flex h-2.5 w-2.5">
        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
      </span>
      <span>ONLINE</span>
    </div>
  </div>

  <!-- BOTÓN DE FICHAJE INTELIGENTE EN ESPAÑOL -->
  @if(!$turnoActivo)
  <form action="{{ route('pda.fichar') }}" method="POST" class="flex items-center gap-2 pt-1">
    @csrf
    <!-- Botón principal para iniciar jornada laboral (Estilo Verde Esmeralda) -->
    <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 px-4 bg-emerald-600 hover:bg-emerald-700 active:scale-[0.98] text-white font-bold rounded-xl shadow-md transition-all duration-150">
      <!-- Icono vectorial de reloj para temporizador de fichaje -->
      <svg class="w-5 h-5 text-emerald-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 9 0 0118 0z" />
      </svg>
      <span>INICIAR JORNADA EN ENTRADA</span>
    </button>
  </form>
  @else
  <form action="{{ route('pda.salir') }}" method="POST" class="flex items-center gap-2 pt-1">
    @csrf
    <!-- OPCIÓN B: Botón para REGISTRAR SALIDA / FINALIZAR la jornada (Rojo Carmesí con el mismo diseño) -->
    <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 px-4 bg-rose-600 hover:bg-rose-700 active:scale-[0.98] text-white font-bold rounded-xl shadow-md transition-all duration-150">
      <!-- Icono vectorial de salida / puerta de salida -->
      <svg class="w-5 h-5 text-rose-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3m0-18v1a3 3 0 003 3h4" />
      </svg>
      <span>REGISTRAR SALIDA DE JORNADA</span>
    </button>
  </form>
  @endif
</header>

<!-- ALERTAS URGENTES (TASKS DONDE IS_URGENT = 1) -->
@foreach($tareas->where('is_urgent', 1) as $urgente)
<section class="wire-box-dashed p-3 rounded-lg flex flex-col gap-2 bg-red-50 mb-2 border-red-500">
  <div class="flex items-center justify-between">
    <span class="text-[10px] font-black uppercase text-red-900 flex items-center gap-1.5">
      <span class="w-2 h-2 rounded-full bg-red-600 animate-ping"></span>
      ¡AVISO URGENTE!
    </span>
    <span class="text-[9px] border border-red-900 px-1 font-bold bg-red-200 text-red-900">URGENTE</span>
  </div>

  <div class="bg-white border border-zinc-900 p-2 text-xs">
    <p class="font-bold">Habitación: {{ $urgente->room->room_number ?? 'N/A' }}</p>
    <p class="text-[11px] text-zinc-600"><strong>{{ $urgente->title }}:</strong> {{ $urgente->description }}</p>
  </div>
</section>
@endforeach

<!-- LISTADO DE TAREAS DESDE LA BASE DE DATOS (TABLE: TASKS) -->
<section class="flex flex-col gap-2">
  <div class="flex justify-between items-center text-xs font-bold border-b border-zinc-300 pb-1">
    <span>MIS TAREAS ASIGNADAS</span>
    <span class="text-[10px] text-zinc-500 font-normal">{{ $tareas->count() }} tareas</span>
  </div>

  @forelse($tareas as $tarea)
  <div class="wire-box p-2.5 rounded flex flex-col gap-1.5">
    <div class="flex justify-between items-start">
      <span class="font-bold text-xs">Hab. {{ $tarea->room->room_number ?? 'General' }}</span>
      <span class="text-[9px] px-1 border border-zinc-900 bg-zinc-900 text-white font-bold uppercase">
        {{ $tarea->status }}
      </span>
    </div>
    <p class="text-[11px] text-zinc-600"><strong>{{ $tarea->title }}:</strong> {{ $tarea->description }}</p>

    <!-- Formulario unificado con las acciones start y complete de vuestro TaskController -->
    <div class="flex gap-1.5 pt-1">
      @if($tarea->status === 'Pending')
      <form action="{{ route('tasks.start', $tarea->id) }}" method="POST" class="flex-1">
        @csrf
        <button type="submit" class="w-full py-1 text-[10px] wire-box bg-white font-bold hover:bg-zinc-100 text-center cursor-pointer">
          Iniciar
        </button>
      </form>
      @else
      <form action="{{ route('tasks.complete', $tarea->id) }}" method="POST" class="flex-1">
        @csrf
        <button type="submit" class="w-full py-1 text-[10px] wire-box bg-zinc-900 text-white font-bold hover:bg-zinc-800 text-center Jack-pointer cursor-pointer">
          Finalizar
        </button>
      </form>
      @endif
    </div>
  </div>
  @empty
  <p class="text-xs text-zinc-500 text-center py-4">No tienes tareas asignadas hoy.</p>
  @endforelse
</section>

<!-- ESCÁNER QR -->
<section class="border-t-2 border-zinc-900 pt-3">
  <!-- Botón secundario para apertura del escáner QR del Buffet (Estilo Azul y Dorado corporativo) -->
  <button type="button" class="w-full flex items-center justify-center gap-2 py-3.5 px-4 bg-slate-900 hover:bg-slate-800 active:scale-[0.98] text-amber-400 border border-amber-500/30 font-bold rounded-xl shadow-md transition-all duration-150">
    <!-- Icono vectorial de lector / escáner de código QR -->
    <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m0 14v1m8-8h-1M5 12H4m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
    </svg>
    <span>ABRIR ESCÁNER QR BUFFET</span>
  </button>
</section>
@endsection;