<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Task;
use Illuminate\Http\Request;

class GobernantaController extends Controller
{
    /**
     * Muestra el panel operativo analítico de la Gobernanta
     */
    public function index()
    {
        // Contadores para los KPIs del Dashboard y la gráfica de Chart.js
        $occupiedRooms = Room::where('status', 'Occupied')->count();
        $dirtyRooms = Room::where('status', 'Cleaning')->count();
        $availableRooms = Room::where('status', 'Available')->count();
        $maintenanceRooms = Room::where('status', 'Maintenance')->count();

        // Filtro rápido de incidencias críticas o urgentes pendientes de resolver
        $urgentTasks = Task::where('priority', 'High')
                            ->where('status', 'Pending')
                            ->with(['room', 'user'])
                            ->get();

        return view('gobernanta.index', compact(
            'occupiedRooms', 
            'dirtyRooms', 
            'availableRooms', 
            'maintenanceRooms',
            'urgentTasks'
        ));
    }
}
