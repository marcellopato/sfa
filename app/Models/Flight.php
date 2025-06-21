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

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'departure_time' => 'datetime',
        'arrival_time' => 'datetime',
        'price' => 'float',
    ];

    public function reservations()
    {
        return $this->hasMany(\App\Models\Reservation::class);
    }
}
