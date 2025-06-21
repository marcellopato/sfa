<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Flight;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'flight_id' => Flight::factory(),
            'reservation_code' => 'SFA-' . strtoupper(\Illuminate\Support\Str::random(8)),
            'reservation_date' => now(),
            'status' => 'confirmed',
            'total_price' => function (array $attributes) {
                return Flight::find($attributes['flight_id'])->price;
            }
        ];
    }
} 