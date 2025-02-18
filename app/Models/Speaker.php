<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Speaker extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'photo',
        'expertise',
        'social_links',
    ];

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_speakers');
    }
}