<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;// Conexion con bd
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'payment_method',
        'payment_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}