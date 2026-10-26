<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // 1. FUNCIÓN PARA VER TODAS LAS TAREAS
    public function index()
    {
        // Trae todas las tareas de la base de datos
        $tareas = Task::all(); 

        // Devuelve las tareas en un formato limpio para la pantalla
        return response()->json($tareas);
    }

    // 2. FUNCIÓN PARA CREAR UNA NUEVA TAREA
    public function store(Request $request)
    {
        // Guarda en la base de datos lo que se escribe en el formulario
        $nuevaTarea = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => 'Pending' // Empieza siempre como Pendiente
        ]);

        // Avisa que la tarea se creó bien
        return response()->json([
            'mensaje' => '¡Tarea creada con éxito!',
            'tarea' => $nuevaTarea
        ]);
    }

    // 3. FUNCIÓN PARA MARCAR UNA TAREA COMO COMPLETADA (Desde la PDA)
    public function complete($id)
    {
        // Busca la tarea en la base de datos usando su ID
        $tarea = Task::find($id);

        // Le cambia el estado a completada
        $tarea->status = 'Completed';

        // Guarda el cambio definitivo en la base de datos
        $tarea->save();

        // Avisa que se actualizó correctamente
        return response()->json([
            'mensaje' => '¡Tarea completada en la PDA!',
            'tarea' => $tarea
        ]);
    }
}
