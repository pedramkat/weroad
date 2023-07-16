<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TourResource extends JsonResource
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
            'startingDate' => date_format($this->startingDate,'Y-m-d'),
            'endingDate' => date_format($this->endingDate,'Y-m-d'),
            'price' => number_format($this->price, 2),
        ];
    }
}
