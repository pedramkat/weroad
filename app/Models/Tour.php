<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tour extends Model
{
    use HasFactory;
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'travelId',
        'name',
        'startingDate',
        'endingDate',
        'price',
    ];

    /**
     * Casting attributes.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'startingDate' => 'date',
        'endingDate' => 'date',
    ];

    /**
     * The belongs to relation with Travel model.
     *
     * @return BelongsTo
     */
    public function travel(): BelongsTo
    {
        return $this->belongsTo(Travel::class);
    }
}
