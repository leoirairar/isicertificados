<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = [
        'enrollments_id', 
        'payment', 
        'bill_serial',
        'payment_day',
        'payment_status'
    ];

    public function employeeEnrollment()
    {
        return $this->belongsTo('App\EmployeeEnrollment','enrollments_id');
    }
}
