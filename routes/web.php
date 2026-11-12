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


// 3. RUTAS PROTEGIDAS (Soporte directo para Admin sin conflictos de middleware)
Route::middleware(['auth'])->group(function () {

    // ZONA: RECEPCIÓN
    Route::get('/recepcion', [RecepcionController::class, 'index'])->name('recepcion.index');

    // ZONA: GOBERNANTA Y TAREAS
    Route::get('/gobernanta', [GobernantaController::class, 'index'])->name('gobernanta.index');
    Route::get('/gobernanta/tareas', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/gobernanta/tareas/crear', [TaskController::class, 'store'])->name('tasks.store');

    // ZONA: COMERCIAL
    Route::get('/comercial', [ComercialController::class, 'index'])->name('comercial.index');
    Route::post('/comercial/reservar', [ComercialController::class, 'store'])->name('comercial.store');

    // ZONA: TERMINAL PDA MÓVIL Y FICHAJES
    Route::get('/pda', [ShiftController::class, 'index'])->name('pda.index');
    Route::post('/pda/fichar', [ShiftController::class, 'clockIn'])->name('pda.fichar');
    Route::post('/pda/salir', [ShiftController::class, 'clockOut'])->name('pda.salir');
    
    // Acciones operativas sobre tareas
    Route::post('/pda/tarea/{id}/empezar', [TaskController::class, 'start'])->name('tasks.start');
    Route::post('/pda/tarea/{id}/completar', [TaskController::class, 'complete'])->name('tasks.complete');
});