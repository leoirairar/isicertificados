<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Instructor extends Model
{
    use SoftDeletes;

    protected  $dates = ['deleted_at'];

    public function academicDegrees(){
        return $this->belongsToMany('App\AcademicDegree', 'instructor_degrees','instructor_id','academy_degree_id'); 
      }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
