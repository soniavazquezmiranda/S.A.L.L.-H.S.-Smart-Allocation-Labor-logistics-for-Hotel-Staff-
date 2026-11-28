<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Event;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RecepcionController extends Controller
{
    /**
     * Muestra el cuadro de mando de Recepción
     */
    public function index()
    {
        $occupiedRooms  = Room::where('status', 'Occupied')->count();
        $dirtyRooms     = Room::where('status', 'Cleaning')->count();
        $availableRooms = Room::where('status', 'Available')->count();

        // Listado completo de habitaciones ordenadas por número para gestionar Check-In / Check-Out
        $rooms = Room::orderBy('room_number')->get();

        // Cuenta las salidas/check-outs agendados para el día de hoy
        $pendingCheckouts = Event::whereDate('end_date', Carbon::today())->count();

        // Trae los eventos programados para hoy con sus habitaciones asociadas
        $todayEvents = Event::whereDate('start_date', Carbon::today())
                            ->with('room')
                            ->get();

        return view('recepcion.index', compact(
            'occupiedRooms',
            'dirtyRooms',
            'availableRooms',
            'rooms',
            'pendingCheckouts',
            'todayEvents'
        ));
    }

    /**
     * Procesa el Check-In de una habitación disponible
     */
    public function checkIn(Request $request, $roomId)
    {
        $room = Room::findOrFail($roomId);

        if ($room->status !== 'Available') {
            return back()->with('error', "La habitación {$room->room_number} no está disponible para Check-In.");
        }

        $room->update(['status' => 'Occupied']);

        return back()->with('success', "Check-In registrado correctamente en {$room->room_number}.");
    }

    /**
     * Procesa el Check-Out de una habitación:
     * 1. Cambia la habitación a 'Cleaning' (Pendiente de limpieza).
     * 2. Cierra el evento/estancia activa de esa habitación si estaba en curso.
     * 3. Genera automáticamente una tarea urgente para Housekeeping (Gobernanta / PDA).
     */
    public function checkOut(Request $request, $roomId)
    {
        $room = Room::findOrFail($roomId);

        if ($room->status !== 'Occupied') {
            return back()->with('error', "La habitación {$room->room_number} no está ocupada actualmente.");
        }

        DB::transaction(function () use ($room) {
            // 1. Cambiar estado de la habitación a 'Cleaning'
            $room->update([
                'status' => 'Cleaning',
            ]);

            // 2. Si hay un evento/estancia asociada a esta habitación que termina hoy o sigue activa, lo cerramos
            $activeEvent = Event::where('room_id', $room->id)
                ->whereDate('end_date', '>=', Carbon::today())
                ->latest()
                ->first();

            if ($activeEvent && isset($activeEvent->status)) {
                $activeEvent->update(['status' => 'Completed']);
            }

            // 3. Crear orden urgente automática para Pisos / Gobernanta / PDA
            Task::create([
                'creator_id'  => Auth::id(),
                'room_id'     => $room->id,
                'title'       => "Limpieza Check-Out - {$room->room_number}",
                'description' => "Salida de cliente registrada en Recepción. Preparar {$room->room_number} ({$room->type}, Planta {$room->floor}).",
                'priority'    => 'High',
                'is_urgent'   => true,
                'status'      => 'Pending',
                'start_date'  => now(),
            ]);
        });

        return back()->with('success', "Check-Out realizado en {$room->room_number}. Habitación marcada para limpieza y alerta urgente enviada a Gobernanta/PDA.");
    }
}
