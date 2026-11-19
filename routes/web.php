<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\RecepcionController;
use App\Http\Controllers\ComercialController;
use App\Http\Controllers\GobernantaController;

// 1. RUTA DE BIENVENIDA
Route::get('/', function () {
    return view('welcome');
});

// 2. AUTENTICACIÓN / LOGIN (Público)
Route::get('/login', function () {
    if (Auth::check()) {
        return redirect()->to(match(Auth::user()->role) {
            'Admin', 'Limpieza', 'Mantenimiento' => '/pda',
            'Recepcion' => '/recepcion',
            'Comercial' => '/comercial',
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
            'Admin', 'Limpieza', 'Mantenimiento' => '/pda',
            'Recepcion' => '/recepcion',
            'Comercial' => '/comercial',
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

// 3. RUTAS PROTEGIDAS (100% Unificadas en Español con acceso global para Admin)
Route::middleware(['auth'])->group(function () {

    // ZONA: RECEPCIÓN (Acceso para Recepcion y Admin)
    Route::middleware(['role:Recepcion,Admin'])->group(function () {
        Route::get('/recepcion', [RecepcionController::class, 'index'])->name('recepcion.index');
    });

    // ZONA: GOBERNANTA (Acceso para Limpieza y Admin)
    Route::middleware(['role:Limpieza,Admin'])->group(function () {
        Route::get('/gobernanta', [GobernantaController::class, 'index'])->name('gobernanta.index');
        Route::get('/gobernanta/tareas', [TaskController::class, 'index'])->name('tasks.index');
    });

    // CREACIÓN DE TAREAS / CHECK-OUT (Necesario para Recepcion, Limpieza y Admin)
    Route::middleware(['role:Recepcion,Limpieza,Admin'])->group(function () {
        Route::post('/gobernanta/tareas/crear', [TaskController::class, 'store'])->name('tasks.store');
    });

    // ZONA: COMERCIAL (Acceso para Comercial y Admin)
    Route::middleware(['role:Comercial,Admin'])->group(function () {
        Route::get('/comercial', [ComercialController::class, 'index'])->name('comercial.index');
        Route::post('/comercial/reservar', [ComercialController::class, 'store'])->name('comercial.store');
    });

    // ZONA: TERMINAL PDA MÓVIL Y FICHAJES
    Route::get('/pda', [ShiftController::class, 'index'])->name('pda.index');
    Route::post('/pda/fichar', [ShiftController::class, 'clockIn'])->name('pda.fichar');
    Route::post('/pda/salir', [ShiftController::class, 'clockOut'])->name('pda.salir');
    
    // Acciones operativas sobre los cometidos en la PDA
    Route::post('/pda/tarea/{id}/empezar', [TaskController::class, 'start'])->name('tasks.start');
    Route::post('/pda/tarea/{id}/completar', [TaskController::class, 'complete'])->name('tasks.complete');
});