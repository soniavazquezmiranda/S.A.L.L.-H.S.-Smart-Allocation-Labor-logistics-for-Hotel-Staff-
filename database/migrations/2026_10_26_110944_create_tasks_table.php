<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();

            // Relaciones de usuarios (Quién crea vs Quién ejecuta)
            $table->foreignId('creator_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

            // Contexto de ubicación o evento
            $table->foreignId('room_id')->nullable()->constrained('rooms')->onDelete('set null');
            $table->foreignId('event_id')->nullable()->constrained('events')->onDelete('set null');

            // Prioridad e indicador de alerta
            $table->enum('priority', ['Low', 'Medium', 'High'])->default('Medium');
            $table->boolean('is_urgent')->default(false);

            // Ciclo de vida completo de la tarea
            $table->enum('status', [
                'Pending',
                'Accepted',
                'In_Progress',
                'Completed',
                'Rejected',
                'Cancelled'
            ])->default('Pending');

            // Motivo si el operario rechaza la tarea
            $table->text('rejection_reason')->nullable();

            // Tiempos de control
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
