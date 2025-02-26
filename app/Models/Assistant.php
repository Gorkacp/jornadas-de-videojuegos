<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;// Conexion con bd
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Assistant extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        'event_id',
        'name',
        'email',
        'attendance_type',
        'payment_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}