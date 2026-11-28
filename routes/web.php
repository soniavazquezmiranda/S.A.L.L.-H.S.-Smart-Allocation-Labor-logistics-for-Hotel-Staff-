<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\RecepcionController;
use App\Http\Controllers\ComercialController;
use App\Http\Controllers\GobernantaController;
use App\Http\Controllers\AdminController; // [AÑADIDO] Controlador del Panel Maestro de Administración

// 1. RUTA DE BIENVENIDA
Route::get('/', function () {
    return view('welcome');
});

// 2. AUTENTICACIÓN / LOGIN (Público)
Route::get('/login', function () {
    if (Auth::check()) {
        return redirect()->to(match(Auth::user()->role) {
            'Admin' => '/admin', // [AÑADIDO] Redirección directa del Administrador a su panel
            'Gobernanta' => '/gobernanta', // [AÑADIDO] Redirección directa de la Gobernanta
            'Recepcion', 'Recepcion_Jefe' => '/recepcion', // [MODIFICADO] Incluye Jefatura de Recepción
            'Comercial' => '/comercial',
            'Limpieza', 'Mantenimiento', 'Restaurante_Jefe' => '/pda', // [MODIFICADO] Incluye Jefatura de Restaurante
            default => '/',
        });
    }
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        
        return redirect()->to(match(Auth::user()->role) {
            'Admin' => '/admin', // [AÑADIDO] Acceso directo al Panel Administrador
            'Gobernanta' => '/gobernanta', // [AÑADIDO] Acceso directo al Panel de Gobernanta
            'Recepcion', 'Recepcion_Jefe' => '/recepcion', // [MODIFICADO] Incluye Jefatura de Recepción
            'Comercial' => '/comercial',
            'Limpieza', 'Mantenimiento', 'Restaurante_Jefe' => '/pda', // [MODIFICADO] Incluye Jefatura de Restaurante
            default => '/',
        });
    }

    return back()->withErrors(['email' => 'Las credenciales no coinciden con nuestros registros.']);
})->name('login.post');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');


// 3. RUTAS PROTEGIDAS (100% Unificadas en Español)
Route::middleware(['auth'])->group(function () {

    // =========================================================================
    // [AÑADIDO] ZONA: ADMINISTRACIÓN GENERAL (Acceso EXCLUSIVO para Admin)
    // =========================================================================
   Route::middleware(['role:Admin,Gobernanta,Recepcion_Jefe,Restaurante_Jefe,Mantenimiento'])->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    });

    // ZONA: RECEPCIÓN
    Route::middleware(['role:Recepcion,Recepcion_Jefe,Admin'])->group(function () { // [MODIFICADO] Añadido Recepcion_Jefe
        Route::get('/recepcion', [RecepcionController::class, 'index'])->name('recepcion.index');
        Route::post('/recepcion/checkin/{room}', [RecepcionController::class, 'checkIn'])->name('recepcion.checkin');
        Route::post('/recepcion/checkout/{room}', [RecepcionController::class, 'checkOut'])->name('recepcion.checkout');

    });

    // ZONA: GOBERNANTA
    Route::middleware(['role:Gobernanta,Admin'])->group(function () { // [MODIFICADO] Cuadro de habitaciones exclusivo para Gobernanta y Admin
        Route::get('/gobernanta', [GobernantaController::class, 'index'])->name('gobernanta.index');
    });

    // GESTIÓN Y ASIGNACIÓN DE TAREAS
    Route::middleware(['role:Gobernanta,Recepcion_Jefe,Restaurante_Jefe,Mantenimiento,Admin'])->group(function () { // [MODIFICADO] Jefes de área y Admin
        Route::get('/gobernanta/tareas', [TaskController::class, 'index'])->name('tasks.index');
    });

    // CREACIÓN DE TAREAS
    Route::middleware(['role:Recepcion,Recepcion_Jefe,Gobernanta,Limpieza,Restaurante_Jefe,Mantenimiento,Admin'])->group(function () {
        Route::post('/gobernanta/tareas/crear', [TaskController::class, 'store'])->name('tasks.store');
    });

    // ZONA: COMERCIAL
    Route::middleware(['role:Comercial,Admin'])->group(function () {
        Route::get('/comercial', [ComercialController::class, 'index'])->name('comercial.index');
        Route::post('/comercial/reservar', [ComercialController::class, 'store'])->name('comercial.store');
    });

    // ZONA: TERMINAL PDA MÓVIL Y FICHAJES (Nombres en perfecto castellano)
    Route::get('/pda', [ShiftController::class, 'index'])->name('pda.index');
    
    // Mapeado con el formulario de entrada y salida de ShiftController
    Route::post('/pda/fichar', [ShiftController::class, 'clockIn'])->name('pda.fichar');
    Route::post('/pda/salir', [ShiftController::class, 'clockOut'])->name('pda.salir');
    
    // Acciones operativas sobre los cometidos en la PDA
    Route::post('/pda/tarea/{id}/empezar', [TaskController::class, 'start'])->name('tasks.start');
    Route::post('/pda/tarea/{id}/completar', [TaskController::class, 'complete'])->name('tasks.complete');
});
