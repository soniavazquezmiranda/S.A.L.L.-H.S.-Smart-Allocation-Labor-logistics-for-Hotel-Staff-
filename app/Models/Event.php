<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

    protected $fillable = [
        'title',
        'room_id',
        'start_date',
        'end_date',
        'event_status',
    ];
    
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
