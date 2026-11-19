<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Lista todas las tareas en el panel de control técnico o gobernanta
     */
    public function index()
    {
        $tareas = Task::with(['room', 'assignee'])->orderBy('created_at', 'desc')->get(); 
        $habitaciones = Room::all();
        $empleados = User::whereIn('role', ['Limpieza', 'Mantenimiento'])->get();

        return view('tasks.index', compact('tareas', 'habitaciones', 'empleados'));
    }

    /**
     * Crea una nueva tarea (disparador manual o por check-out).
     */
    public function store(Request $request)
    {
        // Si viene is_urgent sin priority explícito, asigna High o Medium por defecto
        if (!$request->filled('priority')) {
            $request->merge([
                'priority' => $request->boolean('is_urgent') ? 'High' : 'Medium',
            ]);
        }

        // Si la descripción viene vacía en el alta rápida, rellena un texto por defecto
        if (!$request->filled('description')) {
            $request->merge([
                'description' => 'Orden operativa asignada desde el panel de tareas.',
            ]);
        }

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'room_id'     => 'required|exists:rooms,id',
            'priority'    => 'required|in:Low,Medium,High',
            'user_id'     => 'nullable|exists:users,id',
        ]);

        // Crea la tarea en estado pendiente y vincula al operario si se seleccionó
        Task::create([
            'title'       => $validated['title'],
            'description' => $validated['description'],
            'room_id'     => $validated['room_id'],
            'user_id'     => $validated['user_id'] ?? null,
            'priority'    => $validated['priority'],
            'status'      => 'Pending',
            'is_urgent'   => $validated['priority'] === 'High' ? 1 : 0,
        ]);

        // Si la habitación estaba ocupada, pasa a estar en limpieza (Cleaning)
        $room = Room::find($validated['room_id']);
        if ($room && $room->status === 'Occupied') {
            $room->update(['status' => 'Cleaning']);
        }

        return redirect()->back()->with('success', '¡Tarea creada con éxito en estado Pendiente!');
    }

    /**
     * El operario inicia la tarea desde la PDA.
     */
    public function start($id)
    {
        $tarea = Task::findOrFail($id);
        $tarea->update([
            'status'      => 'In_Progress',
            'user_id' => Auth::id(),
            'accepted_at' => $tarea->accepted_at ?? now(),
        ]);

        return redirect()->back()->with('success', 'Tarea iniciada: ahora está En Ejecución.');
    }

    /**
     * El operario completa la tarea y libera automáticamente la habitación
     */
    public function complete($id)
    {
        $tarea = Task::findOrFail($id);
        $tarea->update(['status' => 'Completed']);

        // Al terminar de limpiar, la habitación vuelve a estar en Disponible (Available)
        $room = Room::find($tarea->room_id);
        if ($room && $room->status === 'Cleaning') {
            $room->update(['status' => 'Available']);
        }

        return redirect()->back()->with('success', ' ¡Tarea completada! Habitación disponible.');
    }
}
