<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{

    protected $fillable = [
        'user_id',
        'cafe_id',
        'rating',
        'comment',
    ];

    public function cafe()
    {
        return $this->belongsTo(Cafe::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::created(function ($review) {
            $review->cafe->updateAverageRating();
        });
    }
}
