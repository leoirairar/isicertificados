<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademicDegree extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    public function emplpoyee()
    {
        return $this->belongsTo('App\Employee','academy_degree_id','id');
    }

    public function instructor()
    {
      return $this->belongsToMany('App\Instructor', 'instructor_degrees','instructor_id','academy_degree_id');
    }
}
