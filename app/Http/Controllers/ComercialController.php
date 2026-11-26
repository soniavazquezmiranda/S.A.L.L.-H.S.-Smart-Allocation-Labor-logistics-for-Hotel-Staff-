<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Room;
use App\Models\Task;
use Illuminate\Http\Request;

class ComercialController extends Controller
{
    public function index()
    {
        $events = Event::with('room')->orderBy('start_date', 'asc')->get();
        $espaciosComerciales = Room::whereIn('type', ['Lounge', 'Restaurant', 'Courtyard', 'Executive Suite'])->get();

        return view('comercial.index', compact('events', 'espaciosComerciales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'room_id' => 'required|exists:rooms,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'catering_plan' => 'required|string',
            'notes' => 'nullable|string'
        ]);

        $event = Event::create([
            'space_id' => $request->room_id,
            'client_name' => $request->client_name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'catering_plan' => $request->catering_plan,
            'notes' => $request->notes
        ]);

        $room = Room::find($request->room_id);
        $room->update(['status' => 'Occupied']);

        Task::create([
            'title' => 'Montaje de Evento: ' . $request->client_name,
            'description' => "Preparar " . $room->room_number . ". Catering: " . $request->catering_plan . ". Notas: " . $request->notes,
            'room_id' => $room->id,
            'user_id' => null,
            'priority' => 'High',
            'status' => 'Pending',
            'is_urgent' => 1
        ]);

        return redirect()->back()->with('success', '¡Evento registrado! Tarea enviada a las PDAs.');
    }
}
