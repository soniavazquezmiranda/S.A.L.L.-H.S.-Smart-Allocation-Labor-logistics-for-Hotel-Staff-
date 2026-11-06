<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $table = 'shifts';

    protected $fillable = [
        'user_id',
        'clock_in',
        'clock_out',
    ];

    // Relación: El fichaje/turno pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}