<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\RecepcionController;
use App\Http\Controllers\ComercialController;
use App\Http\Controllers\GobernantaController;

//Sin autenticacion para rama develop
Route::get('/', function () { return view('welcome'); });

Route::get('/recepcion', [RecepcionController::class, 'index'])->name('recepcion.index');
Route::get('/gobernanta', [GobernantaController::class, 'index'])->name('gobernanta.index');
Route::get('/comercial', [ComercialController::class, 'index'])->name('comercial.index');
Route::get('/pda', [ShiftController::class, 'index'])->name('pda.index');