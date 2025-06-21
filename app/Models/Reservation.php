<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'flight_id',
        'reservation_code',
        'reservation_date',
        'status',
        'total_price',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'reservation_date' => 'datetime',
        'total_price' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function flight()
    {
        return $this->belongsTo(\App\Models\Flight::class);
    }
}
