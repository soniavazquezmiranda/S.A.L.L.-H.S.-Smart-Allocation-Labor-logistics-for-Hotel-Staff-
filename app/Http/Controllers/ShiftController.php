<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShiftController extends Controller
{
    /**
     * Muestra la pantalla principal de la PDA con turnos y tareas asignadas o en cola.
     */
    public function index()
    {
        $idUsuario = Auth::id();
        $usuarioActual = Auth::user();

        // Obtiene los últimos 5 fichajes de este operario
        $historialFichajes = Shift::where('user_id', $idUsuario)
            ->orderBy('clock_in', 'desc')
            ->take(5)
            ->get();

        // Carga las tareas activas asignadas al operario o disponibles en la cola general
        $consultaTareas = Task::whereIn('status', ['Pending', 'In_Progress'])
            ->with('room')
            ->orderByDesc('is_urgent')
            ->orderByDesc('created_at');

        if (($usuarioActual->role ?? '') !== 'Admin') {
            $consultaTareas->where(function ($query) use ($idUsuario) {
                $query->where('user_id', $idUsuario)
                    ->orWhereNull('user_id');
            });
        }

        $tareas = $consultaTareas->get();

        // Busca si hay un turno abierto actualmente para el operario
        $turnoActivo = Shift::where('user_id', $idUsuario)
            ->whereNull('clock_out')
            ->first();

        return view('pda.index', compact('historialFichajes', 'tareas', 'turnoActivo'));
    }

    /**
     * Registra la entrada de jornada (Clock In) en la PDA.
     */
    public function clockIn(Request $request)
    {
        $idUsuario = Auth::id();

        $existeTurno = Shift::where('user_id', $idUsuario)
            ->whereNull('clock_out')
            ->exists();

        if ($existeTurno) {
            return redirect()->back()->with('error', 'Ya tienes una jornada laboral activa.');
        }

        Shift::create([
            'user_id'     => $idUsuario,
            'clock_in'    => now(),
            'clock_out'   => null,
            'total_hours' => null,
        ]);

        return redirect()->back()->with('success', 'Entrada registrada en la PDA. ¡Buen turno!');
    }

    /**
     * Registra la salida de jornada (Clock Out) con cálculo automático de horas.
     */
    public function clockOut(Request $request)
    {
        $idUsuario = Auth::id();

        $fichajeActivo = Shift::where('user_id', $idUsuario)
            ->whereNull('clock_out')
            ->first();

        if (!$fichajeActivo) {
            return redirect()->back()->with('error', 'No se ha encontrado ninguna jornada activa para cerrar.');
        }

        $horaSalida = now();
        $horaEntrada = Carbon::parse($fichajeActivo->clock_in);

        // Calcula la diferencia en horas con dos decimales
        $totalHoras = $horaEntrada->diffInMinutes($horaSalida) / 60;

        $fichajeActivo->update([
            'clock_out'   => $horaSalida,
            'total_hours' => round($totalHoras, 2),
        ]);

        return redirect()->back()->with('success', 'Salida registrada. ¡Jornada finalizada!');
    }
}