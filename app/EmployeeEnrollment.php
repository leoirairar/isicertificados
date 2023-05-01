<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Relations\Pivot;

class EmployeeEnrollment extends Model
{
    protected $table = 'course_employees_enrollment';

    protected $fillable = [
        'employee_id', 
        'course_programming_id', 
        'status_employee',
        'reprogrammed',
        'cancel',        
        'observations',        
        'reschedule',        
    ];

    public function attendanceDay()
    {
        return $this->belongsToMany('App\CourseDays','user_class_attendance','enrollment_id','course_day_id')
        ->withPivot([
            'id',
            'enrollment_id',
            'course_day_id',
        ]);;
    }

    public function bill()
    {
        return $this->hasOne('App\Bill','enrollments_id');
    }

    public function employee()
    {
        return $this->belongsTo('App\Employee','employee_id');
    }

    public function courseProgramming()
    {
        return $this->belongsTo('App\CourseProgramming','course_programming_id');
    }
    public function certificate()
    {
        return $this->hasOne('App\CourseCertificate','enrollments_id');
    }

    public function employeeClassAttendance()
    {
        return $this->hasMany('App\EmployeeClassAttendance','enrollment_id');
    }

    

   
}
