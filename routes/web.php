<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ShiftController;

// 1. Ruta de la página de bienvenida (la que viene por defecto)
Route::get('/', function () {
    return view('welcome');
});

// 2. ENLACES PARA LAS TAREAS DE LAS PDAs (TaskController)
Route::get('/tasks', [TaskController::class, 'index']);          // Ver todas las tareas
Route::post('/tasks', [TaskController::class, 'store']);         // Crear una nueva tarea
Route::put('/tasks/{id}/complete', [TaskController::class, 'complete']); // Completar tarea desde la PDA

// 3. ENLACES PARA LOS FICHAJES LABORALES (ShiftController)
Route::get('/shifts', [ShiftController::class, 'index']);        // Ver el historial de turnos
Route::post('/shifts/clock-in', [ShiftController::class, 'clockIn']);   // Registrar entrada al trabajo
Route::put('/shifts/{id}/clock-out', [ShiftController::class, 'clockOut']); // Registrar salida del trabajo
