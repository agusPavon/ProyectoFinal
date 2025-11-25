<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointsHistory extends Model
{


    protected $table = 'points_history';


    protected $fillable = [
        'user_id',
        'action',
       'beans',
  ];

}