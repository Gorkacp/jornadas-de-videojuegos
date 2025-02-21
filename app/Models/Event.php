<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'type',
        'start_time',
        'end_time',
        'max_attendees',
        'price', 
        'speaker_id',
        'user_id', 
    ];

    protected $dates = [
        'start_time',
        'end_time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function speaker()
    {
        return $this->belongsTo(Speaker::class);
    }

    public function assistants()
    {
        return $this->hasMany(Assistant::class);
    }

    public function getAvailableCapacityAttribute()
    {
        return $this->max_attendees - $this->assistants()->count();
    }

    public function isFull()
    {
        return $this->available_capacity <= 0;
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}