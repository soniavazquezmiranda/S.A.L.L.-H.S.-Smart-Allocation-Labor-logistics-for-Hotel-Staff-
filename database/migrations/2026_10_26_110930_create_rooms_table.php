<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration

{public function up(): void
{
    Schema::create('rooms', function (Blueprint $table) {
        $table->id();
        $table->string('room_number')->unique(); // Ej: '101', 'Salón Real', 'Patio Central'
        $table->integer('floor')->default(0);    // Planta (0 para planta baja/patio)
        
        // ENUM ampliado con todos vuestros espacios reales:
        $table->enum('type', ['Single', 'Standard Double', 'Executive Suite', 'Lounge', 'Restaurant', 'Courtyard']); 
        
        // ENUM de estados:
        $table->enum('status', ['Available', 'Occupied', 'Cleaning', 'Maintenance'])->default('Available');
        $table->timestamps();
    });
}



    
};
