<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class EmployeeClassAttendance extends Pivot
{
    protected $table = 'user_class_attendance';
}
