<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    // 1. FUNCIÓN PARA ENTRAR A TRABAJAR (CLOCK IN)
    public function clockIn(Request $request)
    {
        // Registra el inicio de la jornada para el empleado
        $fichajeEntrada = Shift::create([
            'user_id' => $request->user_id, // ID del empleado que ficha
            'clock_in' => now(),            // Fecha y hora exacta de este momento
            'clock_out' => null,            // Aún no ha salido
            'total_hours' => null           // Se calcularán al salir
        ]);

        return response()->json([
            'mensaje' => '¡Entrada registrada en la PDA con éxito!',
            'fichaje' => $fichajeEntrada
        ]);
    }

    // 2. FUNCIÓN PARA SALIR DE TRABAJAR (CLOCK OUT)
    public function clockOut(Request $request, $id)
    {
        // Busca el fichaje actual que abrimos al entrar
        $fichaje = Shift::find($id);

        // Registra la fecha y hora exacta de salida
        $fichaje->clock_out = now();

        // Guarda el cambio definitivo en la base de datos
        $fichaje->save();

        return response()->json([
            'mensaje' => '¡Salida registrada. Jornada finalizada!',
            'fichaje' => $fichaje
        ]);
    }

    // 3. FUNCIÓN PARA VER EL HISTORIAL DE FICHAJES
    public function index()
    {
        // Trae todos los registros de fichajes de la base de datos
        $historial = Shift::all();

        return response()->json($historial);
    }
}
