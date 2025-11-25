<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cafe extends Model {

    protected $fillable = [
        'name',
        'address',
        'lat',
        'lng',
        'description',
        'average_rating',
        'website',
        'roasting_type',
        'origin',
        'milk',
        'coffee_types',
        'milk_options',
        'features',
        'attributes',
        'opening_hours'
    ];

    protected $casts = [
        'features' => 'array',
        'opening_hours' => 'array',
        'milk_options' => 'array',
        'coffee_types' => 'array',
        'attributes' => 'array'
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function updateAverageRating()
    {
        $this->average_rating = $this->reviews()->avg('rating') ?? 0;
        $this->save();
    }
    public function checkins()
    {
        return $this->hasMany(Checkin::class);
    }

}
