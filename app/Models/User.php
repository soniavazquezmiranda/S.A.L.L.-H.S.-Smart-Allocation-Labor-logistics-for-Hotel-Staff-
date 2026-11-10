<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relación: Un usuario (empleado) tiene muchas tareas asignadas
    public function tasks()
    {
        return $this->hasMany(Task::class, 'user_id');
    }

    // Relación: Un usuario tiene varios turnos/fichajes
    public function shifts()
    {
        return $this->hasMany(Shift::class, 'user_id');
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