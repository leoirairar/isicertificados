<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class CourseProgramming extends Model
{
   use SoftDeletes;

    protected $table = 'course_programming';

    
    //protected $dateFormat = 'Y-m-d';
    
    protected $fillable = [
        'begin_date', 
        'end_date', 
        'duration',
        'begin_hour',
        'end_hour',        
        'place',
        'quantity_enrolled_employees',        
    ];

    protected $dates = ['deleted_at','begin_date','end_date'];


    protected $casts = [
        'begin_date' => 'date:d-m-Y',
        'end_date' => 'date:d-m-Y',
    ];


    public function courseDays()
    {
        return $this->hasMany('App\CourseDays');
    }

    public function course()
    {
        return $this->belongsTo('App\Course','course_id','id');
    }

    public function employees()
    {
        return $this->belongsToMany('App\Employee','course_employees_enrollment','course_programming_id','employee_id')
        ->using('App\EmployeeEnrollment')
        ->withPivot([
            'id',
            'employee_id',
            'course_programming_id',
            'status_employee',
            'created_at'
        ]);
    }

    public function employeeEnrollment()
    {
        return $this->hasMany('App\EmployeeEnrollment');
    }

    public function instructor()
    {
        return $this->belongsToMany('App\Instructor','course_instructor','course_programming_id','instructor_id')
        ->using('App\EmployeeEnrollment')
        ->withPivot([
            'instructor_id',
            'course_programming_id',
            'supervisor',
            'status'
        ]);
    }

    public function courseInstructor()
    {
         return $this->hasMany('App\CourseInstructor');
    }

    


    


}
