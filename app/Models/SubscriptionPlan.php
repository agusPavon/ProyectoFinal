<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    protected $fillable = [
        'name',
        'price',
        'description',
        'coffee_bag_size',
        'deliveries_per_month',
    ];
}