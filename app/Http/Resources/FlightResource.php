<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FlightResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'origin' => $this->origin,
            'destination' => $this->destination,
            'departure_time' => $this->departure_time->toIso8601String(),
            'arrival_time' => $this->arrival_time->toIso8601String(),
            'price' => (float) $this->price,
            'aircraft' => $this->aircraft,
            'status' => $this->status,
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }
}
