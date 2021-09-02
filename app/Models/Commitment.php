<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commitment extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'commitments';

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'paid' => false,
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the user's first name.
     *
     * @param  string  $value
     * @return string
     */
    public function getPaidAttribute($value)
    {
        return $value === 1 ? true : false;
    }

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}
