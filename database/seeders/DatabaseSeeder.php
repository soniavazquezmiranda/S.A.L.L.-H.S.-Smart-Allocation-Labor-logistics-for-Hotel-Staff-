<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Department;
use App\Models\Room;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Limpieza automática previa para evitar errores de duplicados
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Room::truncate();
        User::truncate();
        Department::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. Crear los Departamentos obligatorios del Hotel
        $managementDept = Department::create(['name' => 'Management', 'description' => 'Dirección general y administración.']);
        $receptionDept = Department::create(['name' => 'Reception', 'description' => 'Atención al cliente y reservas.']);
        $housekeepingDept = Department::create(['name' => 'Housekeeping', 'description' => 'Limpieza de habitaciones y salones.']);
        $maintenanceDept = Department::create(['name' => 'Maintenance', 'description' => 'Reparación de averías e infraestructura.']);
        $restaurantDept = Department::create(['name' => 'Restaurant', 'description' => 'Personal de buffet, comedores y eventos.']);

        // 2. Crear Empleados del Hotel S.A.L.L. (Contraseña: 12345678)
        User::create([
            'name' => 'Julio', 'email' => 'julio@sall.com', 'password' => Hash::make('12345678'),
            'role' => 'Admin', 'department_id' => $managementDept->id
        ]);

         User::create([
            'name' => 'Alonso', 'email' => 'alonso@sall.com', 'password' => Hash::make('12345678'),
            'role' => 'Admin', 'department_id' => $managementDept->id
        ]);
         User::create([
            'name' => 'Sonia', 'email' => 'sonia@sall.com', 'password' => Hash::make('12345678'),
            'role' => 'Admin', 'department_id' => $managementDept->id
        ]);

        User::create([
            'name' => 'Liudmyla', 'email' => 'liudmyla@sall.com', 'password' => Hash::make('12345678'),
            'role' => 'Admin', 'department_id' => $managementDept->id
        ]);

        User::create([
            'name' => 'Recepción', 'email' => 'recepcion@sall.com', 'password' => Hash::make('12345678'),
            'role' => 'Recepcion', 'department_id' => $receptionDept->id
        ]);

        User::create([
            'name' => 'Limpieza', 'email' => 'limpieza@sall.com', 'password' => Hash::make('12345678'),
            'role' => 'Limpieza', 'department_id' => $housekeepingDept->id
        ]);

        User::create([
            'name' => 'Mantenimiento', 'email' => 'mantenimiento@sall.com', 'password' => Hash::make('12345678'),
            'role' => 'Mantenimiento', 'department_id' => $maintenanceDept->id
        ]);

        User::create([
            'name' => 'Comercial', 'email' => 'comercial@sall.com', 'password' => Hash::make('12345678'),
            'role' => 'Comercial', 'department_id' => $managementDept->id
        ]);

        // ¡NUEVO! Añadimos al Maître de restauración unificado con acceso a la PDA
        User::create([
            'name' => 'Maître Sergio', 
            'email' => 'maitre@sall.com', // Correo corporativo limpio
            'password' => Hash::make('12345678'),
            'role' => 'Limpieza', // Rol operativo para que el Middleware le deje ver la PDA
            'department_id' => $restaurantDept->id // Vinculado a Restauración
        ]);

        // 3. Crear Habitaciones, Salones, Restaurante y el Patio del Hotel
        Room::create(['room_number' => '101', 'floor' => 1, 'type' => 'Single', 'status' => 'Available']);
        Room::create(['room_number' => '102', 'floor' => 1, 'type' => 'Executive Suite', 'status' => 'Available']);
        Room::create(['room_number' => '201', 'floor' => 2, 'type' => 'Standard Double', 'status' => 'Cleaning']);
        Room::create(['room_number' => 'Salón Real', 'floor' => 0, 'type' => 'Lounge', 'status' => 'Available']);
        Room::create(['room_number' => 'Zona Restaurante Buffet', 'floor' => 0, 'type' => 'Restaurant', 'status' => 'Available']);
        Room::create(['room_number' => 'Patio Andaluz Central', 'floor' => 0, 'type' => 'Courtyard', 'status' => 'Available']);
    }
}
