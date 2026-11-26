<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'creator_id',
        'assigned_to',
        'room_id',
        'event_id',
        'priority',
        'is_urgent',
        'status',
        'rejection_reason',
        'start_date',
        'end_date',
        'accepted_at',
        'completed_at',
    ];

    protected $casts = [
        'is_urgent' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'accepted_at' => 'datetime',
        'completed_at' => 'datetime',
    ];





    //Relaciones

    /**
     * Usuario que dio de alta la tarea (Recepción, Gobernanta o Comercial).
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * Operario asignado que atiende la tarea desde la PDA.
     */
    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Habitación asociada a la incidencia (si aplica).
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Evento asociado (si proviene de Comercial).
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }







    // --- Métodos Auxiliares de Estado ---

    public function isPending(): bool
    {
        return $this->status === 'Pending';
    }

    public function isAccepted(): bool
    {
        return $this->status === 'Accepted';
    }

    public function isInProgress(): bool
    {
        return $this->status === 'In_Progress';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'Completed';
    }

    public function isRejected(): bool
    {
        return $this->status === 'Rejected';
    }






    // --- Transiciones de Estado ---

    /**
     * El operario acepta la tarea desde la PDA.
     */
    public function markAsAccepted(int $userId): void
    {
        $this->update([
            'status' => 'Accepted',
            'assigned_to' => $userId,
            'accepted_at' => now(),
        ]);
    }

    /**
     * El operario rechaza la tarea con un motivo opcional.
     */
    public function markAsRejected(?string $reason = null): void
    {
        $this->update([
            'status' => 'Rejected',
            'rejection_reason' => $reason,
        ]);
    }

    /**
     * El operario finaliza la tarea.
     */
    public function markAsCompleted(): void
    {
        $this->update([
            'status' => 'Completed',
            'completed_at' => now(),
        ]);
    }

}