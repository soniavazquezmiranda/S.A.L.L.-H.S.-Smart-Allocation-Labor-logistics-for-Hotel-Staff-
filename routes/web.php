<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\RecepcionController;
use App\Http\Controllers\ComercialController;
use App\Http\Controllers\GobernantaController;

Route::get('/', function () {
    return view('welcome');
});

// Función auxiliar de redirección según rol
$redirectByRole = function ($role) {
    return match($role) {
        'Admin', 'Recepcion' => '/recepcion',
        'Gobernanta'         => '/gobernanta',
        'Comercial'          => '/comercial',
        'Trabajador'         => '/pda',
        default              => '/',
    };
};

// AUTENTICACIÓN
Route::get('/login', function () use ($redirectByRole) {
    if (Auth::check()) {
        return redirect()->to($redirectByRole(Auth::user()->role));
    }
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) use ($redirectByRole) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->to($redirectByRole(Auth::user()->role));
    }

    return back()->withErrors(['email' => 'Las credenciales no coinciden con nuestros registros.']);
})->name('login.post');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// RUTAS PROTEGIDAS POR ROL (Admin entra en todas gracias a RoleMiddleware)
Route::middleware(['auth'])->group(function () {

    Route::middleware(['role:Recepcion,Admin'])->group(function () {
        Route::get('/recepcion', [RecepcionController::class, 'index'])->name('recepcion.index');
    });

    Route::middleware(['role:Gobernanta,Admin'])->group(function () {
        Route::get('/gobernanta', [GobernantaController::class, 'index'])->name('gobernanta.index');
        Route::get('/gobernanta/tareas', [TaskController::class, 'index'])->name('tasks.index');
    });

    Route::middleware(['role:Comercial,Admin'])->group(function () {
        Route::get('/comercial', [ComercialController::class, 'index'])->name('comercial.index');
    });

    Route::middleware(['role:Trabajador,Admin'])->group(function () {
        Route::get('/pda', [ShiftController::class, 'index'])->name('pda.index');
    });
});