<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class FlightFactory extends Factory
{
    public function definition(): array
    {
        $origins = ['GRU', 'GIG', 'BSB', 'CGH', 'SDU', 'CNF', 'POA', 'REC', 'SSA', 'CWB'];
        $destinations = ['GRU', 'GIG', 'BSB', 'CGH', 'SDU', 'CNF', 'POA', 'REC', 'SSA', 'CWB'];
        $origin = $this->faker->randomElement($origins);
        do {
            $destination = $this->faker->randomElement($destinations);
        } while ($destination === $origin);
        $departure = $this->faker->dateTimeBetween('+1 days', '+30 days');
        $arrival = (clone $departure)->modify('+' . rand(1, 8) . ' hours');
        return [
            'code' => strtoupper(Str::random(2)) . $this->faker->unique()->numberBetween(100, 999),
            'origin' => $origin,
            'destination' => $destination,
            'departure_time' => $departure,
            'arrival_time' => $arrival,
            'price' => $this->faker->randomFloat(2, 10000, 150000),
            'aircraft' => $this->faker->randomElement(['Gulfstream G650', 'Embraer Phenom 300', 'Cessna Citation XLS+', 'Bombardier Global 7500', 'Dassault Falcon 8X']),
            'status' => $this->faker->randomElement(['scheduled', 'cancelled', 'completed']),
        ];
    }
} 