<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{

    protected $fillable = [
        'holiday_date',
        'start', 
        'end', 
        'name',
        'country'      
    ];
}
