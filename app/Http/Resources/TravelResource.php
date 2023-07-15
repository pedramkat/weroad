<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TravelResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'numberOfDays' => $this->numberOfDays,
            'numberOfNights' => $this->numberOfNights,
            'nature'=> 80,
            'relax'=> 20,
            'history'=> 90,
            'culture'=> 30,
            'party'=> 10,
        ];
    }
}
