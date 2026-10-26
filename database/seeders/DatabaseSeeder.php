<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Department;
use App\Models\Room;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Crear los Departamentos obligatorios en Inglés
        $managementDept = Department::create([
            'name' => 'Management',
            'description' => 'Dirección general y administración del hotel.'
        ]);

        $receptionDept = Department::create([
            'name' => 'Reception',
            'description' => 'Atención al cliente, reservas de estancias y alquiler de salones.'
        ]);

        $housekeepingDept = Department::create([
            'name' => 'Housekeeping',
            'description' => 'Mantenimiento higiénico de habitaciones, salones y zonas comunes.'
        ]);

        $maintenanceDept = Department::create([
            'name' => 'Maintenance',
            'description' => 'Mantenimiento preventivo y reparación de averías de la infraestructura.'
        ]);

        $restaurantDept = Department::create([
            'name' => 'Restaurant',
            'description' => 'Personal de sala, banquetes, buffet y desayunos.'
        ]);

        // 2. Crear tus Empleados de prueba adaptados a los Roles en inglés
        User::create([
            'name' => 'Julio Director',
            'email' => 'direccion@sall.com',
            'password' => Hash::make('12345678'),
            'role' => 'Management',
            'department_id' => $managementDept->id
        ]);

        User::create([
            'name' => 'LuzMila Recepcionista',
            'email' => 'recepcion@sall.com',
            'password' => Hash::make('12345678'),
            'role' => 'Reception',
            'department_id' => $receptionDept->id
        ]);

        User::create([
            'name' => 'Sonia Gobernanta',
            'email' => 'limpieza@sall.com',
            'password' => Hash::make('12345678'),
            'role' => 'Housekeeping',
            'department_id' => $housekeepingDept->id
        ]);

        User::create([
            'name' => 'Alonso Técnico',
            'email' => 'mantenimiento@sall.com',
            'password' => Hash::make('12345678'),
            'role' => 'Maintenance',
            'department_id' => $maintenanceDept->id
        ]);

        User::create([
            'name' => 'Camarero Staff',
            'email' => 'restaurante@sall.com',
            'password' => Hash::make('12345678'),
            'role' => 'Restaurant',
            'department_id' => $restaurantDept->id
        ]);

        // 3. Crear Habitaciones y Salones de prueba en Inglés
        Room::create([
            'room_number' => '101', 'floor' => 1, 'type' => 'Single', 'status' => 'Available'
        ]);
        Room::create([
            'room_number' => '102', 'floor' => 1, 'type' => 'Executive Suite', 'status' => 'Available'
        ]);
        Room::create([
            'room_number' => '201', 'floor' => 2, 'type' => 'Standard Double', 'status' => 'Cleaning'
        ]);
        Room::create([
            'room_number' => 'Salón Real', 'floor' => 0, 'type' => 'Lounge', 'status' => 'Available'
        ]);
        Room::create([
            'room_number' => 'Zona Restaurante Buffet', 'floor' => 0, 'type' => 'Restaurant', 'status' => 'Available'
        ]);
    }
}
