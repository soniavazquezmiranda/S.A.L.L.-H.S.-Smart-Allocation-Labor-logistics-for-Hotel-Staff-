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
        $tareas = Task::with(['room', 'user'])->orderBy('created_at', 'desc')->get(); 
        $habitaciones = Room::all();
        $empleados = User::whereIn('role', ['Limpieza', 'Mantenimiento'])->get();

        return view('gobernanta.index', compact('tareas', 'habitaciones', 'empleados'));
    }

    /**
     * Crea una nueva tarea (Disparador manual o por Check-out)
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'room_id' => 'required|exists:rooms,id',
            'priority' => 'required|in:Low,Medium,High',
            'user_id' => 'nullable|exists:users,id'
        ]);

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'room_id' => $request->room_id,
            'user_id' => $request->user_id,
            'priority' => $request->priority,
            'status' => 'Pending',
            'is_urgent' => $request->priority === 'High' ? 1 : 0
        ]);

        // Si la habitación estaba ocupada, pasa a estar en estado de Limpieza (Cleaning)
        $room = Room::find($request->room_id);
        if ($room && $room->status === 'Occupied') {
            $room->update(['status' => 'Cleaning']);
        }

        return redirect()->back()->with('success', '¡Tarea creada con éxito!');
    }

    /**
     * El operario inicia la tarea desde la PDA
     */
    public function start($id)
    {
        $tarea = Task::findOrFail($id);
        $tarea->update([
            'status' => 'In_Progress',
            'user_id' => Auth::id() // Se autoasigna al empleado que le da al botón
        ]);

        return redirect()->back()->with('success', 'Tarea iniciada en tu terminal.');
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
