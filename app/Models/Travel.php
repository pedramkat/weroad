<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
