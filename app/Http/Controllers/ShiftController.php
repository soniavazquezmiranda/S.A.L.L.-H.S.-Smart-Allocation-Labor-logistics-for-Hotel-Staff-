<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use App\Models\Task;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ShiftController extends Controller
{
    /**
     * Muestra la pantalla principal de la PDA con turnos y tareas asignadas
     */
    public function index()
    {
        $userId = Auth::id();

        // TABLA 'shifts': Trae los últimos 5 fichajes de este operario
        $historialFichajes = Shift::where('user_id', $userId)
                                  ->orderBy('clock_in', 'desc')
                                  ->take(5)
                                  ->get();

        // TABLA 'tasks': CORREGIDO en minúsculas para sincronizar con Blade
        $tareas = Task::where('user_id', $userId)
                         ->whereIn('status', ['Pending', 'In_Progress'])
                         ->with('room') // Vincula los datos de la habitación o patio
                         ->get();

        // Busca si hay un turno abierto actualmente
        $turnoActivo = Shift::where('user_id', $userId)
                            ->whereNull('clock_out')
                            ->first();

        // compact unificado con la variable corregida en minúsculas
        return view('pda.index', compact('historialFichajes', 'tareas', 'turnoActivo'));
    }

    /**
     * Registrar Entrada de Jornada (Clock In)
     */
    public function clockIn(Request $request)
    {
        $userId = Auth::id();

        $existeTurno = Shift::where('user_id', $userId)->whereNull('clock_out')->exists();
        if ($existeTurno) {
            return redirect()->back()->with('error', 'Ya tienes una jornada laboral activa.');
        }

        Shift::create([
            'user_id' => $userId,
            'clock_in' => now(),
            'clock_out' => null,
            'total_hours' => null
        ]);

        return redirect()->back()->with('success', 'Entrada registrada en la PDA. ¡Buen turno!');
    }

    /**
     * Registrar Salida de Jornada (Clock Out) con cálculo automático de horas
     */
    public function clockOut(Request $request)
    {
        $userId = Auth::id();

        $fichajeActivo = Shift::where('user_id', $userId)
                              ->whereNull('clock_out')
                              ->first();

        if (!$fichajeActivo) {
            return redirect()->back()->with('error', 'No se ha encontrado ninguna jornada activa para cerrar.');
        }

        $horaSalida = now();
        $horaEntrada = Carbon::parse($fichajeActivo->clock_in);

        // Diferencia en horas con decimales (ej: 8.5 horas)
        $totalHoras = $horaEntrada->diffInMinutes($horaSalida) / 60;

        $fichajeActivo->update([
            'clock_out' => $horaSalida,
            'total_hours' => round($totalHoras, 2)
        ]);

        return redirect()->back()->with('success', 'Salida registrada. ¡Jornada finalizada!');
    }
}
