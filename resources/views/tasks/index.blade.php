@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <!-- 1. BANNER PRINCIPAL DE GESTIÓN DE TAREAS EN BORGOÑA Y BRONCE 3D -->
    <header class="banner-3d-burgundy rounded-tl-[2.25rem] rounded-br-[2.25rem] rounded-tr-none rounded-bl-none p-3 sm:p-4 text-white">
        <div class="rounded-tl-[1.75rem] rounded-br-[1.75rem] rounded-tr-none rounded-bl-none border border-[#E6BE9A]/25 p-5 sm:p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="min-w-0">
                <div class="flex items-center gap-2 text-[11px] uppercase tracking-[0.24em] text-[#E6BE9A] font-bold mb-1.5">
                    <span>Operaciones &amp; Asignación</span>
                    <span>•</span>
                    <span>Flujo en Tiempo Real</span>
                </div>
                <h1 class="font-serif text-3xl sm:text-4xl font-bold text-[#FDF8F4] tracking-tight">
                    Hotel Grand Central <span class="italic font-semibold text-[#E6BE9A]">— Gestión de Tareas</span>
                </h1>
                <p class="text-xs text-[#D9C4C9] mt-1.5">
                    Creación de órdenes de limpieza, mantenimiento urgente y seguimiento de estados PDA
                </p>
            </div>

            <div class="flex items-center gap-3 text-xs bg-[#140509]/70 border border-[#E6BE9A]/30 px-4 py-2.5 rounded-tl-2xl rounded-br-2xl rounded-tr-none rounded-bl-none shadow-inner shrink-0 whitespace-nowrap">
                <div class="text-left sm:text-right">
                    <span class="text-[#C7AEB5] block text-[10px] uppercase tracking-wider">Coordinación</span>
                    <strong class="text-[#FDF8F4] text-xs">{{ auth()->user()->name ?? 'Gobernanta' }}</strong>
                </div>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-tl-lg rounded-br-lg rounded-tr-none rounded-bl-none bg-[#4A1926] border border-[#7A2C41] text-[#F5DEC9] font-semibold text-[11px]">
                    <span class="w-2 h-2 rounded-full bg-[#E6BE9A] animate-pulse"></span>
                    Activo
                </span>
            </div>
        </div>
    </header>

    <!-- 2. TARJETAS KPI DE ÓRDENES DE TRABAJO -->
    @php
        $listaTareas = $tareas ?? $tasks ?? collect();
        $totalTareas = $listaTareas->count();
        $tareasPendientes = $listaTareas->where('status', 'Pending')->count();
        $tareasEnCurso = $listaTareas->whereIn('status', ['In_Progress', 'In Progress', 'En Curso', 'Started'])->count();
        $tareasCompletadas = $listaTareas->whereIn('status', ['Completed', 'Completada', 'Done'])->count();
    @endphp

    <section class="grid grid-cols-1 min-[480px]:grid-cols-2 lg:grid-cols-4 gap-5 text-xs">
        <div class="card-3d-champagne p-5 rounded-tl-[1.75rem] rounded-br-[1.75rem] rounded-tr-none rounded-bl-none border-l-[5px] border-l-[#2B0D16] flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[11px] text-stone-600 uppercase font-bold tracking-wider">Total Órdenes</span>
                <span class="w-8 h-8 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none bg-[#F3ECE6] border border-[#D6C7BC] flex items-center justify-center text-[#2B0D16]">
                    <i class="bi bi-clipboard-data text-sm"></i>
                </span>
            </div>
            <div class="font-serif text-4xl font-bold text-[#2B0D16] my-2.5">{{ $totalTareas }}</div>
            <p class="text-[11px] text-stone-500">Registradas en el turno</p>
        </div>

        <div class="card-3d-champagne p-5 rounded-tl-[1.75rem] rounded-br-[1.75rem] rounded-tr-none rounded-bl-none border-l-[5px] border-l-[#A87344] flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[11px] text-[#8C5C32] uppercase font-bold tracking-wider">Pendientes</span>
                <span class="w-8 h-8 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none bg-[#F7EFE6] border border-[#DEC7AF] flex items-center justify-center text-[#A87344]">
                    <i class="bi bi-hourglass-split text-sm"></i>
                </span>
            </div>
            <div class="font-serif text-4xl font-bold text-[#9E6838] my-2.5">{{ $tareasPendientes }}</div>
            <p class="text-[11px] text-[#8C5C32]/85 font-medium">En espera de inicio PDA</p>
        </div>

        <div class="card-3d-champagne p-5 rounded-tl-[1.75rem] rounded-br-[1.75rem] rounded-tr-none rounded-bl-none border-l-[5px] border-l-[#632234] flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[11px] text-stone-600 uppercase font-bold tracking-wider">En Ejecución</span>
                <span class="w-8 h-8 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none bg-[#F3ECE6] border border-[#D6C7BC] flex items-center justify-center text-[#632234]">
                    <i class="bi bi-arrow-repeat text-sm"></i>
                </span>
            </div>
            <div class="font-serif text-4xl font-bold text-[#4A1926] my-2.5">{{ $tareasEnCurso }}</div>
            <p class="text-[11px] text-stone-500">Operarios trabajando ahora</p>
        </div>

        <div class="card-3d-champagne p-5 rounded-tl-[1.75rem] rounded-br-[1.75rem] rounded-tr-none rounded-bl-none border-l-[5px] border-l-emerald-800 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[11px] text-stone-600 uppercase font-bold tracking-wider">Completadas</span>
                <span class="w-8 h-8 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none bg-emerald-50 border border-emerald-200 flex items-center justify-center text-emerald-800">
                    <i class="bi bi-check2-all text-sm"></i>
                </span>
            </div>
            <div class="font-serif text-4xl font-bold text-emerald-800 my-2.5">{{ $tareasCompletadas }}</div>
            <p class="text-[11px] text-stone-500">Verificadas y cerradas</p>
        </div>
    </section>

    <!-- 3. FORMULARIO DE NUEVA ORDEN Y LISTADO OPERATIVO -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- Formulario de creación rápida de tarea -->
        <section class="lg:col-span-4 card-3d-champagne p-6 rounded-tl-[2rem] rounded-br-[2rem] rounded-tr-none rounded-bl-none border-t-[5px] border-t-[#2B0D16] space-y-4 text-xs">
            <div class="border-b border-stone-200 pb-3">
                <span class="text-[10px] uppercase font-bold text-[#8C5C32] tracking-[0.2em] block">Nueva Orden</span>
                <h2 class="font-serif text-xl font-bold text-[#2B0D16] mt-0.5">Asignar Tarea a PDA</h2>
            </div>

            <!-- Mensajes de validación o confirmación de operación -->
            @if ($errors->any())
                <div class="p-3 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none bg-rose-900 text-white text-xs space-y-1">
                    @foreach ($errors->all() as $error)
                        <div>• {{ $error }}</div>
                    @endforeach
                </div>
            @endif

            @if (session('success'))
                <div class="p-3 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none bg-emerald-800 text-white text-xs font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('tasks.store') }}" method="POST" class="space-y-3.5">
                @csrf

                <!-- Selector de habitación o zona desde el catálogo -->
                <div>
                    <label class="block text-[11px] font-bold text-[#2B0D16] uppercase tracking-wider mb-1">Habitación / Zona *</label>
                    @if(!empty($habitaciones) && count($habitaciones) > 0)
                        <select name="room_id" required class="w-full recessed-3d-champagne px-3.5 py-2.5 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none text-stone-800 font-medium focus:outline-none focus:border-[#4A1926] focus:bg-white transition-all">
                            @foreach($habitaciones as $hab)
                                <option value="{{ $hab->id }}">
                                    Hab. {{ $hab->room_number ?? $hab->number ?? $hab->id }} (Planta {{ $hab->floor ?? '1' }})
                                </option>
                            @endforeach
                        </select>
                    @else
                        <input type="text" name="room_id" required placeholder="Ej. 104 o Salón Noble" 
                               class="w-full recessed-3d-champagne px-3.5 py-2.5 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none text-stone-800 placeholder-stone-400 focus:outline-none focus:border-[#4A1926] focus:bg-white transition-all">
                    @endif
                </div>

                <!-- Selector de empleado si existen empleados cargados -->
                @if(!empty($empleados) && count($empleados) > 0)
                <div>
                    <label class="block text-[11px] font-bold text-[#2B0D16] uppercase tracking-wider mb-1">Operario Asignado</label>
                    <select name="user_id" class="w-full recessed-3d-champagne px-3.5 py-2.5 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none text-stone-800 font-medium focus:outline-none focus:border-[#4A1926] focus:bg-white transition-all">
                        <option value="">-- Cola General PDA (Sin asignar) --</option>
                        @foreach($empleados as $emp)
                            <option value="{{ $emp->id }}">{{ $emp->name }} ({{ $emp->role }})</option>
                        @endforeach
                    </select>
                </div>
                @endif

                <!-- Prioridad requerida por la validación del controlador -->
                <div>
                    <label class="block text-[11px] font-bold text-[#2B0D16] uppercase tracking-wider mb-1">Prioridad *</label>
                    <select name="priority" required class="w-full recessed-3d-champagne px-3.5 py-2.5 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none text-stone-800 font-medium focus:outline-none focus:border-[#4A1926] focus:bg-white transition-all">
                        <option value="Medium">Media (Normal)</option>
                        <option value="High">Alta (Urgente)</option>
                        <option value="Low">Baja</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-[#2B0D16] uppercase tracking-wider mb-1">Título de la Orden *</label>
                    <input type="text" name="title" required placeholder="Ej. Limpieza profunda salida VIP" 
                           class="w-full recessed-3d-champagne px-3.5 py-2.5 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none text-stone-800 placeholder-stone-400 focus:outline-none focus:border-[#4A1926] focus:bg-white transition-all">
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-[#2B0D16] uppercase tracking-wider mb-1">Instrucciones *</label>
                    <textarea name="description" rows="2" required placeholder="Detalles adicionales para el operario..." 
                              class="w-full recessed-3d-champagne px-3.5 py-2 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none text-stone-800 placeholder-stone-400 focus:outline-none focus:border-[#4A1926] focus:bg-white transition-all"></textarea>
                </div>

                <label class="flex items-center gap-2.5 p-2.5 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none recessed-3d-champagne cursor-pointer">
                    <input type="checkbox" name="is_urgent" value="1" class="accent-[#4A1926] w-4 h-4">
                    <span class="font-bold text-[#4A1926]">Marcar como prioridad urgente</span>
                </label>

                <button type="submit" class="btn-3d-bronze w-full py-3 px-4 text-white font-bold rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none text-xs uppercase tracking-wider flex items-center justify-center gap-2 cursor-pointer">
                    <i class="bi bi-send-plus"></i>
                    <span>Enviar Orden a PDA</span>
                </button>
            </form>
        </section>

        <!-- Tabla de tareas activas -->
        <section class="lg:col-span-8 card-3d-champagne rounded-tl-[2rem] rounded-br-[2rem] rounded-tr-none rounded-bl-none overflow-hidden text-xs">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[580px]">
                    <thead class="bg-[#2B0D16] text-[#FDF8F4] uppercase text-[11px] tracking-wider border-b-2 border-[#120408]">
                        <tr>
                            <th class="p-4 pl-6 font-bold">Ubicación</th>
                            <th class="p-4 font-bold">Tarea / Descripción</th>
                            <th class="p-4 font-bold">Prioridad</th>
                            <th class="p-4 font-bold">Estado</th>
                            <th class="p-4 pr-6 font-bold text-right">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-200/80">
                        @forelse($listaTareas as $tarea)
                            <tr class="hover:bg-[#F3ECE6]/80 transition-colors">
                                <td class="p-4 pl-6 font-bold text-[#2B0D16] whitespace-nowrap">
                                    <span class="inline-block px-2.5 py-0.5 rounded-tl-lg rounded-br-lg rounded-tr-none rounded-bl-none bg-[#F3ECE6] border border-[#D6C7BC]">
                                        {{ $tarea->room->room_number ?? $tarea->room->number ?? $tarea->room_id ?? 'General' }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    <div class="font-bold text-stone-900">{{ $tarea->title }}</div>
                                    @if(!empty($tarea->description))
                                        <div class="text-[11px] text-stone-500 mt-0.5">{{ $tarea->description }}</div>
                                    @endif
                                </td>
                                <td class="p-4 whitespace-nowrap">
                                    @if($tarea->is_urgent || ($tarea->priority ?? '') === 'High')
                                        <span class="px-2.5 py-0.5 rounded-tl-lg rounded-br-lg rounded-tr-none rounded-bl-none bg-[#2B0D16] text-[#F5DEC9] font-bold text-[10px] uppercase">Urgente</span>
                                    @else
                                        <span class="px-2.5 py-0.5 rounded-tl-lg rounded-br-lg rounded-tr-none rounded-bl-none bg-stone-100 border border-stone-300 text-stone-600 font-semibold text-[10px] uppercase">
                                            {{ $tarea->priority ?? 'Normal' }}
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4 whitespace-nowrap">
                                    <span class="px-2.5 py-1 rounded-tl-lg rounded-br-lg rounded-tr-none rounded-bl-none bg-[#F7EFE6] border border-[#DEC7AF] text-[#7D512B] font-bold text-[10px] uppercase">
                                        {{ $tarea->status }}
                                    </span>
                                </td>
                                <td class="p-4 pr-6 text-right whitespace-nowrap">
                                    @if($tarea->status === 'Pending')
                                        <form action="{{ route('tasks.start', $tarea->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit" class="btn-3d-burgundy px-3 py-1.5 text-[#FDF8F4] font-bold rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none text-[11px] cursor-pointer">
                                                Iniciar
                                            </button>
                                        </form>
                                    @elseif(!in_array($tarea->status, ['Completed', 'Completada', 'Done']))
                                        <form action="{{ route('tasks.complete', $tarea->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit" class="btn-3d-bronze px-3 py-1.5 text-white font-bold rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none text-[11px] cursor-pointer">
                                                Finalizar
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-emerald-800 font-bold text-[11px]"><i class="bi bi-check2-circle"></i> Lista</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-stone-500">No hay tareas registradas en este momento.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

    </div>

</div>
@endsection