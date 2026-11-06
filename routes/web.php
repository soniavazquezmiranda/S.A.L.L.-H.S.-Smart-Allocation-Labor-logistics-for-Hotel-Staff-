<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ShiftController;

// 1. Ruta de la página de bienvenida
Route::get('/', function () {
    return view('welcome');
});

// 2. RUTA PRINCIPAL DE LA PDA (Carga el archivo resources/views/pda/index.blade.php)
Route::get('/pda', [TaskController::class, 'index'])->name('pda.index');

// Rutas de gestión de tareas
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::patch('/tasks/{id}/estado', [TaskController::class, 'cambiarEstado'])->name('tareas.cambiarEstado');

// 3. ENLACES PARA LOS FICHAJES LABORALES (ShiftController)
Route::get('/shifts', [ShiftController::class, 'index'])->name('shifts.index');
Route::post('/shifts/clock-in', [ShiftController::class, 'clockIn'])->name('shifts.clockIn');
Route::post('/pda/fichar', [ShiftController::class, 'clockIn'])->name('pda.fichar');
Route::put('/shifts/{id}/clock-out', [ShiftController::class, 'clockOut'])->name('shifts.clockOut');

// 4. AUTENTICACIÓN / LOGIN
// Ruta para mostrar el formulario de login (GET)
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Ruta para procesar el inicio de sesión (POST)
Route::post('/login', function (Request $request) {
    return redirect('/pda');
})->name('login.post');

// Ruta para el Panel de Recepción
Route::get('/recepcion', function () {
    // Si Alonso ya tiene datos en la DB los toma de ahí, o pasa una colección vacía
    $rooms = class_exists(Room::class) ? Room::all() : collect([]);
    
    return view('recepcion.index', [
        'rooms' => $rooms,
        'totalRooms' => $rooms->count() ?: 52,
        'occupiedRooms' => $rooms->where('status', 'OCUPADA')->count() ?: 38,
        'pendingCheckouts' => 9,
        'dirtyRooms' => $rooms->where('status', 'SUCIA')->count() ?: 5,
    ]);
})->name('recepcion.index');

// Ruta para el Panel Comercial
Route::get('/comercial', function () {
    return view('comercial.index', [
        'events' => collect([]), // Se conectará a la tabla 'events' o 'tasks'
    ]);
})->name('comercial.index');

// Ruta para el Cuadro de Mandos de Gobernanta
Route::get('/shifts', function () {
    return view('gobernanta.index', [
        'completedTasks' => collect([]),
    ]);
})->name('shifts.index');