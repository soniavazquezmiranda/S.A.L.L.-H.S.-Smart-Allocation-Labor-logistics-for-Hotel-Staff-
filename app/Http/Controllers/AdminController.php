<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Room;
use App\Models\Task;
use App\Models\User;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * [MODIFICADO] Muestra el Panel Maestro al Admin (todo el hotel) y el Control de
     * Turnos/Personal a cada Jefe de Departamento (filtrado solo por su departamento).
     */
    public function index()
    {
        $usuarioActual = Auth::user();
        $esAdmin = $usuarioActual->role === 'Admin';

        // Si es Admin carga todos los departamentos; si es Jefe de Área, solo el suyo
        $departamentos = Department::with('users')
            ->when(!$esAdmin, function ($query) use ($usuarioActual) {
                $query->where('id', $usuarioActual->department_id);
            })
            ->get();

        // Contadores globales (KPIs) de ocupación, limpieza, eventos y urgencias
        $totalHabitaciones = Room::count();
        $ocupadas          = Room::where('status', 'Occupied')->count();
        $sucias            = Room::where('status', 'Cleaning')->count();
        $tareasUrgentes    = Task::where('is_urgent', 1)->whereIn('status', ['Pending', 'In_Progress'])->count();
        $eventosActivos    = Event::count();

        // Si es Admin carga toda la plantilla; si es Jefe, solo los empleados y turnos de su departamento
        $empleadosConFichajes = User::with([
            'department',
            'shifts' => function ($query) {
                $query->orderBy('clock_in', 'desc');
            }
        ])
        ->when(!$esAdmin, function ($query) use ($usuarioActual) {
            $query->where('department_id', $usuarioActual->department_id);
        })
        ->orderBy('name', 'asc')
        ->get();

        return view('admin.index', compact(
            'departamentos',
            'totalHabitaciones',
            'ocupadas',
            'sucias',
            'tareasUrgentes',
            'eventosActivos',
            'empleadosConFichajes'
        ));
    }
}
