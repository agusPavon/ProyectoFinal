<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CafeSuggestion extends Model
{
    protected $fillable = [
        'name',
        'address',
        'website',
        'latitude',
        'longitude',
        'roasting_type',
        'attributes',
        'status',
    ];
}
