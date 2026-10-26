<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Room;

class HotelCoreSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Insertar los Departamentos Oficiales del Hotel
        $departments = [
            ['name' => 'Management', 'description' => 'Dirección general y administración del hotel.'],
            ['name' => 'Reception', 'description' => 'Atención al cliente, reservas y check-in/out.'],
            ['name' => 'Housekeeping', 'description' => 'Servicio de limpieza de habitaciones y áreas comunes.'],
            ['name' => 'Maintenance', 'description' => 'Reparaciones técnicas, fontanería y electricidad.'],
            ['name' => 'Restaurant', 'description' => 'Cocina, sala y servicio de desayunos/eventos.'],
        ];

        foreach ($departments as $dept) {
            Department::create($dept);
        }

        // 2. Insertar Habitaciones y Salones de Prueba
        $rooms = [
            // Planta 1: Habitaciones Estándar
            ['room_number' => '101', 'floor' => 1, 'type' => 'Single', 'status' => 'Available'],
            ['room_number' => '102', 'floor' => 1, 'type' => 'Single', 'status' => 'Available'],
            ['room_number' => '103', 'floor' => 1, 'type' => 'Suite', 'status' => 'Cleaning'],
            
            // Planta 2: Habitaciones Superiores
            ['room_number' => '201', 'floor' => 2, 'type' => 'Suite', 'status' => 'Occupied'],
            ['room_number' => '202', 'floor' => 2, 'type' => 'Single', 'status' => 'Maintenance'],
            
            // Áreas de Eventos Comerciales
            ['room_number' => 'Lounge-Grand', 'floor' => 0, 'type' => 'Lounge', 'status' => 'Available'],
            ['room_number' => 'Restaurant-Hall', 'floor' => 0, 'type' => 'Restaurant', 'status' => 'Available'],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}
