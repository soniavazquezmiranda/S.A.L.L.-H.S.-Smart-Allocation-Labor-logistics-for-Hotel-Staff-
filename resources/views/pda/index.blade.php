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
        <div class="text-[10px] font-bold px-1.5 py-0.5 border border-zinc-900 rounded bg-zinc-100">
          ● ONLINE
        </div>
      </div>

      <!-- BOTÓN DE FICHAJE INTELIGENTE EN ESPAÑOL -->
      @if(!$turnoActivo)
        <form action="{{ route('pda.fichar') }}" method="POST" class="flex items-center gap-2 pt-1">
          @csrf
          <button type="submit" class="w-full py-2.5 px-3 wire-box bg-zinc-900 text-white font-bold text-xs uppercase tracking-wider text-center active:bg-zinc-800 transition-colors cursor-pointer">
            [ ⏱ INICIAR JORNADA EN ENTRADA ]
          </button>
        </form>
      @else
        <form action="{{ route('pda.salir') }}" method="POST" class="flex items-center gap-2 pt-1">
          @csrf
          <button type="submit" class="w-full py-2.5 px-3 wire-box bg-rose-600 text-white font-bold text-xs uppercase tracking-wider text-center active:bg-rose-700 transition-colors border-rose-700 cursor-pointer">
            [ ⏱ REGISTRAR SALIDA DE JORNADA ]
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
      <button class="w-full py-3 wire-box bg-white hover:bg-zinc-100 flex items-center justify-center gap-2 text-xs font-bold uppercase cursor-pointer">
        <div class="w-4 h-4 border border-zinc-900 placeholder-x shrink-0"></div>
        <span>[ ABRIR ESCÁNER QR BUFFET ]</span>
      </button>
    </section>
@endsection;

