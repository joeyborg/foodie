<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Venue extends Model
{
    use HasFactory;

    protected $fillable = [
        'wolt_id',
        'name',
        'slug',
        'short_description',
        'address',
        'latitude',
        'longitude',
        'price_range',
        'wolt_rating',
        'delivers',
    ];

    protected $casts = [
        'wolt_rating' => 'json',
        'delivers' => 'boolean',
    ];

    public function items()
    {
        return $this
            ->hasMany(Item::class)
            ->where('type', '!=', 'deal');
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
