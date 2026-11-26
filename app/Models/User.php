<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // [AÑADIDO] Importación necesaria para la relación con Department

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
<<<<<<< Updated upstream
        'department_id',
=======
        'department_id', // [AÑADIDO] Permite asignar y guardar el departamento al que pertenece el empleado
>>>>>>> Stashed changes
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    // Relación: Un usuario tiene varios turnos/fichajes
    public function shifts()
    {
        return $this->hasMany(Shift::class, 'user_id');
    }

    // [AÑADIDO] Relación: Un usuario pertenece a un departamento (permite filtrar fichajes por área y mostrarlo en Admin)
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    /**
     * Tareas creadas por este usuario (Recepción, Gobernanta, Comercial).
     */
    public function createdTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'creator_id');
    }

    /**
     * Tareas asignadas a este usuario (Operario en PDA).
     */
    public function assignedTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }
}
