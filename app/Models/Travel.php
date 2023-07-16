<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Ramsey\Uuid\Type\Integer;

class Travel extends Model
{
    use HasFactory;
    use HasUuids;

    /**
     * The table name of this model.
     *
     * @var string
     */
    protected $table = 'travels';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'slug',
        'name',
        'description',
        'numberOfDays',
        'nature',
        'relax',
        'history',
        'culture',
        'party',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['numberOfNights'];

    /**
     * The belongs to many relation with Tour model.
     *
     * @return HasMany
     */
    public function tours(): HasMany
    {
        return $this->hasMany(Tour::class, 'travelId');
    }

    /**
     * Determine number of nights from the number of days - 1.
     *
     * @return int
     */
    public function getNumberOfNightsAttribute(): int
    {
        $numberOfNights = 0;

        if (!empty($this->numberOfDays) && $this->numberOfDays > 0) {
            $numberOfNights = $this->numberOfDays - 1;
            return $numberOfNights;
        }

        return $numberOfNights;
    }

}
