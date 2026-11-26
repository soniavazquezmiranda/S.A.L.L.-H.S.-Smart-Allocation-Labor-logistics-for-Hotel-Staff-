<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Department;
use App\Models\Room;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Room::truncate();
        User::truncate();
        Department::truncate();
        Schema::enableForeignKeyConstraints();

        // 1. Departamentos
        $managementDept  = Department::create(['name' => 'Management', 'description' => 'Dirección general y administración.']);
        $receptionDept   = Department::create(['name' => 'Reception', 'description' => 'Atención al cliente y reservas.']);
        $housekeepingDept = Department::create(['name' => 'Housekeeping', 'description' => 'Limpieza de habitaciones y salones.']);
        $maintenanceDept = Department::create(['name' => 'Maintenance', 'description' => 'Reparación de averías e infraestructura.']);
        $restaurantDept  = Department::create(['name' => 'Restaurant', 'description' => 'Personal de buffet, comedores y eventos.']);

        // 2. Usuarios de prueba (Contraseña: 12345678)
        User::create([
            'name' => 'Admin', 'email' => 'admin@sall.com', 'password' => Hash::make('12345678'),
            'role' => 'Admin', 'department_id' => $managementDept->id
        ]);

        User::create([
            'name' => 'Recepción', 'email' => 'recepcion@sall.com', 'password' => Hash::make('12345678'),
            'role' => 'Recepcion', 'department_id' => $receptionDept->id
        ]);

        User::create([
            'name' => 'Gobernanta', 'email' => 'gobernanta@sall.com', 'password' => Hash::make('12345678'),
            'role' => 'Gobernanta', 'department_id' => $housekeepingDept->id
        ]);

        User::create([
            'name' => 'Comercial', 'email' => 'comercial@sall.com', 'password' => Hash::make('12345678'),
            'role' => 'Comercial', 'department_id' => $managementDept->id
        ]);

        // Trabajadores operativos (Solo acceso a PDA)
        User::create([
            'name' => 'Trabajador Mantenimiento', 'email' => 'trabajador@sall.com', 'password' => Hash::make('12345678'),
            'role' => 'Trabajador', 'department_id' => $maintenanceDept->id
        ]);

        User::create([
            'name' => 'Maître Sergio', 'email' => 'maitre@sall.com', 'password' => Hash::make('12345678'),
            'role' => 'Trabajador', 'department_id' => $restaurantDept->id
        ]);

        // 3. Habitaciones y espacios base
        Room::create(['room_number' => '101', 'floor' => 1, 'type' => 'Single', 'status' => 'Available']);
        Room::create(['room_number' => '102', 'floor' => 1, 'type' => 'Executive Suite', 'status' => 'Available']);
        Room::create(['room_number' => '201', 'floor' => 2, 'type' => 'Standard Double', 'status' => 'Cleaning']);
        Room::create(['room_number' => 'Salón Real', 'floor' => 0, 'type' => 'Lounge', 'status' => 'Available']);
        Room::create(['room_number' => 'Zona Restaurante Buffet', 'floor' => 0, 'type' => 'Restaurant', 'status' => 'Available']);
        Room::create(['room_number' => 'Patio Andaluz Central', 'floor' => 0, 'type' => 'Courtyard', 'status' => 'Available']);
    }
}