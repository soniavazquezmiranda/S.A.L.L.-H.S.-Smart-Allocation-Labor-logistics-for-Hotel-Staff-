<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Crear los Departamentos obligatorios del hotel
        $recepcionDeptId = DB::table('departamentos')->insertGetId([
            'nombre_departamento' => 'Recepción y Comercial',
            'descripcion' => 'Atención al cliente, reservas de estancias y alquiler de salones.',
            'created_at' => now(), 'updated_at' => now()
        ]);

        $pisosDeptId = DB::table('departamentos')->insertGetId([
            'nombre_departamento' => 'Pisos y Limpieza',
            'descripcion' => 'Mantenimiento higiénico de habitaciones, salones y zonas comunes.',
            'created_at' => now(), 'updated_at' => now()
        ]);

        $mantDeptId = DB::table('departamentos')->insertGetId([
            'nombre_departamento' => 'Servicios Técnicos',
            'descripcion' => 'Mantenimiento preventivo y reparación de averías de la infraestructura.',
            'created_at' => now(), 'updated_at' => now()
        ]);

        $restoDeptId = DB::table('departamentos')->insertGetId([
            'nombre_departamento' => 'Alimentos y Bebidas',
            'descripcion' => 'Personal de sala, banquetes, buffet y desayunos.',
            'created_at' => now(), 'updated_at' => now()
        ]);

        // 2. Crear un Empleado de prueba para cada Rol
        User::create([
            'name' => 'Julio Director',
            'email' => 'direccion@sall.com',
            'password' => Hash::make('12345678'),
            'rol' => 'Dirección',
            'departamento_id' => $recepcionDeptId
        ]);

        User::create([
            'name' => 'LuzMila Recepcionista',
            'email' => 'recepcion@sall.com',
            'password' => Hash::make('12345678'),
            'rol' => 'Recepción',
            'departamento_id' => $recepcionDeptId
        ]);

        User::create([
            'name' => 'Sonia Gobernanta',
            'email' => 'limpieza@sall.com',
            'password' => Hash::make('12345678'),
            'rol' => 'Limpieza',
            'departamento_id' => $pisosDeptId
        ]);

        User::create([
            'name' => 'Alonso Técnico',
            'email' => 'mantenimiento@sall.com',
            'password' => Hash::make('12345678'),
            'rol' => 'Mantenimiento',
            'departamento_id' => $mantDeptId
        ]);

        User::create([
            'name' => 'Camarero Staff',
            'email' => 'restaurante@sall.com',
            'password' => Hash::make('12345678'),
            'rol' => 'Restaurante',
            'departamento_id' => $restoDeptId
        ]);

        // 3. Crear Habitaciones y Salones de prueba
        DB::table('habitaciones')->insert([
            [
                'numero_habitacion' => '101', 'planta' => 1, 'tipo' => 'Individual', 
                'estado' => 'Disponible', 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'numero_habitacion' => '102', 'planta' => 1, 'tipo' => 'Suite Ejecutiva', 
                'estado' => 'Disponible', 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'numero_habitacion' => '201', 'planta' => 2, 'tipo' => 'Doble Estándar', 
                'estado' => 'En Limpieza', 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'numero_habitacion' => 'Salón Real', 'planta' => 0, 'tipo' => 'Salón', 
                'estado' => 'Disponible', 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'numero_habitacion' => 'Zona Restaurante Buffet', 'planta' => 0, 'tipo' => 'Restaurante', 
                'estado' => 'Disponible', 'created_at' => now(), 'updated_at' => now()
            ]
        ]);
    }
}
