<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'venue_id',
        'wolt_id',
        'name',
        'price',
        'original_price',
        'description',
        'image_url',
        'type',
    ];

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }
}
