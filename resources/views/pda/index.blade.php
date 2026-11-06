<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PDA Operario — S.A.L.L. H.S.</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      background-color: #f4f4f5;
      color: #09090b;
      font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
    }
    .wire-box { border: 2px solid #18181b; background-color: #ffffff; }
    .wire-box-dashed { border: 2px dashed #52525b; background-color: #fafafa; }
    .placeholder-x {
      position: relative;
    }
    .placeholder-x::before, .placeholder-x::after {
      content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0;
      background: linear-gradient(to top right, transparent calc(50% - 1px), #a1a1aa, transparent calc(50% + 1px)),
                  linear-gradient(to bottom right, transparent calc(50% - 1px), #a1a1aa, transparent calc(50% + 1px));
    }
  </style>
</head>
<body class="p-3 sm:p-6 flex flex-col items-center justify-start min-h-screen">

  <div class="w-full max-w-sm mb-2 text-center text-xs text-zinc-500 font-bold uppercase tracking-wider">
    [PROYECTO S.A.L.L. H.S. — DISPOSITIVO PDA]
  </div>

  <div class="w-full max-w-[390px] wire-box rounded-2xl p-4 shadow-sm flex flex-col gap-4">

    <!-- CABECERA CON DATOS REALES DE USER -->
    <header class="border-b-2 border-zinc-900 pb-3 flex flex-col gap-2">
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
          <div class="w-8 h-8 wire-box placeholder-x shrink-0"></div>
          <div>
            <h1 class="text-sm font-bold uppercase leading-none">PDA: OPERARIO</h1>
            <!-- Nombre de usuario real de Laravel -->
            <p class="text-[11px] text-zinc-500">{{ auth()->user()->name ?? 'Alonso S.' }} · {{ auth()->user()->role ?? 'Housekeeping' }}</p>
          </div>
        </div>
        <div class="text-[10px] font-bold px-1.5 py-0.5 border border-zinc-900 rounded bg-zinc-100">
          ● ONLINE
        </div>
      </div>

      <!-- BOTÓN DE FICHAJE (SHIFTS) -->
      <form action="{{ route('pda.fichar') }}" method="POST" class="flex items-center gap-2 pt-1">
        @csrf
        <button type="submit" class="flex-1 py-2.5 px-3 wire-box bg-zinc-900 text-white font-bold text-xs uppercase tracking-wider text-center active:bg-zinc-800 transition-colors">
          [ ⏱ REGISTRAR FICHAJE ]
        </button>
      </form>
    </header>

    <!-- ALERTAS URGENTES (TASKS DONDE IS_URGENT = 1) -->
    @foreach($tareas->where('is_urgent', 1) as $urgente)
    <section class="wire-box-dashed p-3 rounded-lg flex flex-col gap-2 bg-red-50">
      <div class="flex items-center justify-between">
        <span class="text-[10px] font-black uppercase text-red-900 flex items-center gap-1.5">
          <span class="w-2 h-2 rounded-full bg-red-600 animate-ping"></span>
          ¡AVISO URGENTE!
        </span>
        <span class="text-[9px] border border-red-900 px-1 font-bold bg-red-200">URGENTE</span>
      </div>

      <div class="bg-white border border-zinc-900 p-2 text-xs">
        <p class="font-bold">Habitación: {{ $urgente->room->room_number ?? 'N/A' }}</p>
        <p class="text-[11px] text-zinc-600">{{ $urgente->title }}: {{ $urgente->description }}</p>
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
        
        <!-- Formulario para cambiar estado de la tarea -->
        <form action="{{ route('tareas.cambiarEstado', $tarea->id) }}" method="POST" class="flex gap-1.5 pt-1">
          @csrf
          @method('PATCH')
          <button type="submit" name="nuevo_estado" value="In_Progress" class="flex-1 py-1 text-[10px] wire-box bg-white font-bold hover:bg-zinc-100">
            Iniciar
          </button>
          <button type="submit" name="nuevo_estado" value="Completed" class="flex-1 py-1 text-[10px] wire-box bg-zinc-100 font-bold hover:bg-zinc-200">
            Finalizar
          </button>
        </form>
      </div>
      @empty
      <p class="text-xs text-zinc-500 text-center py-4">No tienes tareas asignadas hoy.</p>
      @endforelse
    </section>

    <!-- ESCÁNER QR -->
    <section class="border-t-2 border-zinc-900 pt-3">
      <button class="w-full py-3 wire-box bg-white hover:bg-zinc-100 flex items-center justify-center gap-2 text-xs font-bold uppercase">
        <div class="w-4 h-4 border border-zinc-900 placeholder-x shrink-0"></div>
        <span>[ ABRIR ESCÁNER QR BUFFET ]</span>
      </button>
    </section>

  </div>

</body>
</html>