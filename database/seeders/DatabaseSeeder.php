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

        // 1. CREAR LOS DEPARTAMENTOS DEL HOTEL
        $managementDept   = Department::create(['name' => 'Management', 'description' => 'Dirección general y área comercial.']);
        $receptionDept    = Department::create(['name' => 'Reception', 'description' => 'Atención al cliente, check-in y check-out.']);
        $housekeepingDept = Department::create(['name' => 'Housekeeping', 'description' => 'Gobernanta, camareras de piso y zonas nobles.']);
        $maintenanceDept  = Department::create(['name' => 'Maintenance', 'description' => 'Reparación de averías e infraestructura.']);
        $restaurantDept   = Department::create(['name' => 'Restaurant', 'description' => 'Personal de sala, buffet, cocina y eventos.']);

        $pass = Hash::make('12345678');

        // =========================================================================
        // 2. CREAR JEFATURAS, CUENTAS DE ACCESO Y PLANTILLA (Contraseña: 12345678)
        // =========================================================================

        // DIRECCIÓN GENERAL (Acceso total a todo el hotel y auditoría de fichajes)
        User::create([
            'name' => 'Administrador General',
            'email' => 'admin@sall.com',
            'password' => $pass,
            'role' => 'Admin',
            'department_id' => $managementDept->id
        ]);

        // COMERCIAL
        User::create([
            'name' => 'Ludmila (Comercial)',
            'email' => 'comercial@sall.com',
            'password' => $pass,
            'role' => 'Comercial',
            'department_id' => $managementDept->id
        ]);
        // [AÑADIDO] Segunda comercial del departamento
        User::create([
            'name' => 'Loli (Comercial 2)',
            'email' => 'comercial2@sall.com',
            'password' => $pass,
            'role' => 'Comercial',
            'department_id' => $managementDept->id
        ]);

        // RECEPCIÓN
        // [AÑADIDO] Jefatura de Recepción para controlar turnos y asignar tareas
        User::create([
            'name' => 'Jefe de Recepción',
            'email' => 'jeferecepcion@sall.com',
            'password' => $pass,
            'role' => 'Recepcion_Jefe',
            'department_id' => $receptionDept->id
        ]);
        User::create([
            'name' => 'Mostrador Recepción',
            'email' => 'recepcion@sall.com',
            'password' => $pass,
            'role' => 'Recepcion',
            'department_id' => $receptionDept->id
        ]);

        // [AÑADIDO] 6 recepcionistas individuales para el control de fichajes en mostrador
        $recepcionistas = ['Laura Gómez', 'Carlos Ruiz', 'Marta Sánchez', 'David López', 'Elena Navarro', 'Pablo Torres'];
        foreach ($recepcionistas as $i => $nombre) {
            User::create([
                'name' => $nombre . ' (Recepción)',
                'email' => 'recepcion' . ($i + 1) . '@sall.com',
                'password' => $pass,
                'role' => 'Recepcion',
                'department_id' => $receptionDept->id
            ]);
        }

        // GOBERNANTA Y PISOS
        // [AÑADIDO] Gobernanta con rol exclusivo para supervisar habitaciones sucias y fichajes de pisos
        User::create([
            'name' => 'Sonia (Gobernanta)',
            'email' => 'gobernanta@sall.com',
            'password' => $pass,
            'role' => 'Gobernanta',
            'department_id' => $housekeepingDept->id
        ]);
        User::create([
            'name' => 'Terminal Limpieza (PDA)',
            'email' => 'limpieza@sall.com',
            'password' => $pass,
            'role' => 'Limpieza',
            'department_id' => $housekeepingDept->id
        ]);

        // [AÑADIDO] 6 camareras de piso (2 por planta) + 1 encargada de Zonas Nobles y Exterior
        $equipoPisos = [
            'Ana (Camarera Planta 1)', 'Lucía (Camarera Planta 1)',
            'Carmen (Camarera Planta 2)', 'Isabel (Camarera Planta 2)',
            'Rosa (Camarera Planta 3)', 'Teresa (Camarera Planta 3)',
            'Beatriz (Zonas Nobles y Exterior)'
        ];
        foreach ($equipoPisos as $i => $nombre) {
            User::create([
                'name' => $nombre,
                'email' => 'limpieza' . ($i + 1) . '@sall.com',
                'password' => $pass,
                'role' => 'Limpieza',
                'department_id' => $housekeepingDept->id
            ]);
        }

        // RESTAURANTE
        // [MODIFICADO] Maître con rol Restaurante_Jefe para ver turnos y asignar tareas de sala
        User::create([
            'name' => 'Maître Sergio (Jefe Sala)',
            'email' => 'maitre@sall.com',
            'password' => $pass,
            'role' => 'Restaurante_Jefe',
            'department_id' => $restaurantDept->id
        ]);
        // [AÑADIDO] Jefe de Cocina con rol Restaurante_Jefe para supervisar turnos y tareas de cocina
        User::create([
            'name' => 'Chef Javier (Jefe Cocina)',
            'email' => 'jefecocina@sall.com',
            'password' => $pass,
            'role' => 'Restaurante_Jefe',
            'department_id' => $restaurantDept->id
        ]);

        // [AÑADIDO] 6 camareros vinculados al departamento de Restaurante
        $camareros = ['Juan', 'Marcos', 'Sofía', 'Alberto', 'Nuria', 'Diego'];
        foreach ($camareros as $i => $nombre) {
            User::create([
                'name' => $nombre . ' (Camarero)',
                'email' => 'camarero' . ($i + 1) . '@sall.com',
                'password' => $pass,
                'role' => 'Limpieza',
                'department_id' => $restaurantDept->id
            ]);
        }

        // [AÑADIDO] 4 cocineros vinculados al departamento de Restaurante
        $cocineros = ['Raúl', 'Patricia', 'Óscar', 'Cristina'];
        foreach ($cocineros as $i => $nombre) {
            User::create([
                'name' => $nombre . ' (Cocinero)',
                'email' => 'cocinero' . ($i + 1) . '@sall.com',
                'password' => $pass,
                'role' => 'Limpieza',
                'department_id' => $restaurantDept->id
            ]);
        }

        // MANTENIMIENTO
        User::create([
            'name' => 'Alonso (Mantenimiento)',
            'email' => 'mantenimiento@sall.com',
            'password' => $pass,
            'role' => 'Mantenimiento',
            'department_id' => $maintenanceDept->id
        ]);
        // [AÑADIDO] Segundo operario de Mantenimiento
        User::create([
            'name' => 'Jorge (Mantenimiento)',
            'email' => 'mantenimiento2@sall.com',
            'password' => $pass,
            'role' => 'Mantenimiento',
            'department_id' => $maintenanceDept->id
        ]);

        // =========================================================================
        // 3. CREAR HABITACIONES (3 PLANTAS), SALONES, RESTAURANTE Y PATIO CENTRAL
        // =========================================================================
        Room::create(['room_number' => '101', 'floor' => 1, 'type' => 'Single', 'status' => 'Available']);
        Room::create(['room_number' => '102', 'floor' => 1, 'type' => 'Executive Suite', 'status' => 'Available']);
        Room::create(['room_number' => '201', 'floor' => 2, 'type' => 'Standard Double', 'status' => 'Cleaning']);
        Room::create(['room_number' => '301', 'floor' => 3, 'type' => 'Junior Suite', 'status' => 'Available']); // [AÑADIDO] Habitación en Planta 3
        Room::create(['room_number' => 'Salón Real', 'floor' => 0, 'type' => 'Lounge', 'status' => 'Available']);
        Room::create(['room_number' => 'Zona Restaurante Buffet', 'floor' => 0, 'type' => 'Restaurant', 'status' => 'Available']);
        Room::create(['room_number' => 'Patio Andaluz Central', 'floor' => 0, 'type' => 'Courtyard', 'status' => 'Available']);
    }
}
