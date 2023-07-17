<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Travel
 *
 * @property int $numberOfNights
 */
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
            'isPublic' => $this->isPublic,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'numberOfDays' => $this->numberOfDays,
            'numberOfNights' => $this->numberOfNights,
            'nature' => $this->nature,
            'relax' => $this->relax,
            'history' => $this->history,
            'culture' => $this->culture,
            'party' => $this->party,
        ];
    }
}
