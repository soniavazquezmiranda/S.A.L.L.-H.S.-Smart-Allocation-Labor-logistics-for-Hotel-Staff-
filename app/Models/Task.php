<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'room_id',
        'priority',
        'status',
        'start_date',
        'end_date',
        'is_urgent',
    ];

    // Conecction with the user who created the task
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Conecction with the room where the task is assigned
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
}