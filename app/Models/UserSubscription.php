<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    protected $fillable = [
        'user_id',
        'plan_id',
        'status',
        'renews_at'
    ];

    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }
}