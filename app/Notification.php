<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Notification extends Model
{
    protected $fillable = [
        'detail',
        'url', 
        'readed', 
        'user_id',     
    ];

    
}
