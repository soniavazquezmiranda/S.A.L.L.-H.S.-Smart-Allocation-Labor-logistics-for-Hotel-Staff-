<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Event;
use App\Models\Task;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RecepcionController extends Controller
{
    /**
     * Muestra el cuadro de mando de Recepción
     */
    public function index()
    {
        $occupiedRooms = Room::where('status', 'Occupied')->count();
        $dirtyRooms = Room::where('status', 'Cleaning')->count();
        $availableRooms = Room::where('status', 'Available')->count();
        
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
            'pendingCheckouts', 
            'todayEvents'
        ));
    }
}
