<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
