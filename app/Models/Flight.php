<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'origin',
        'destination',
        'departure_time',
        'arrival_time',
        'price',
        'aircraft',
        'status',
    ];

    public function flight()
    {
        return $this->belongsTo(\App\Models\Flight::class);
    }
}
