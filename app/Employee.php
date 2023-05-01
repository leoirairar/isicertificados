<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;


    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id ', 'company_id', 'position', 'birthdate', 'academy_degree_id', 'position', 'emergency_contact_name',
        'emergency_phone_number', 'created_at', 'updated_at', 'password', 'sector_economico'
    ];

    protected $dates = ['deleted_at'];

    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function academicDegree()
    {
        return $this->hasOne('App\AcademicDegree', 'id', 'academy_degree_id');
    }

    public function coursesProgrammed()
    {
        return $this->belongsToMany('App\CourseProgramming', 'course_employees_enrollment', 'employee_id', 'course_programming_id')
            ->using('App\EmployeeEnrollment')
            ->withPivot([
                'id',
                'employee_id',
                'course_programming_id',
                'status_employee',
                'created_at'
            ]);
    }

    public function files()
    {
        return $this->hasMany('App\Files');
    }

    public function employeeEnrollment()
    {
        return $this->hasMany('App\EmployeeEnrollment');
    }
}
