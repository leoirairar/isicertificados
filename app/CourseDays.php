<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseDays extends Model
{
    //protected $dateFormat = 'Y-m-d';

    public function courseProgramming()
    {
        return $this->belongsTo('App\CourseProgramming','course_programming_id','id');
    }
    
    public function employeeEnrollment()
    {
        return $this->belongsToMany('App\EmployeeEnrollment','user_class_attendance','enrollment_id','course_day_id')
        ->withPivot([
            'id',
            'enrollment_id',
            'course_day_id',
        ]);;
    }
}
