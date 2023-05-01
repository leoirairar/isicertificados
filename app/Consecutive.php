<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consecutive extends Model
{
    protected $fillable = [
        'id',
        'course_id'         
    ];

    public function user()
    {
        return $this->belongsTo('App\Course');
    }
}
