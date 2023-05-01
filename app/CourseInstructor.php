<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CourseInstructor extends Pivot
{
    protected $table = 'course_instructor';

    public function instructor()
    {
        return $this->belongsTo('App\Instructor','instructor_id');
    }

    public function courseProgramming()
    {
        return $this->belongsTo('App\CourseProgramming','course_programming_id');
    }
}
