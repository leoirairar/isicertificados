<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProofAttendance extends Model
{
     protected $table = 'proof_attendance';

     protected $fillable = [
        'code',
        'fullname', 
        'identification', 
        'course',     
        'expedition_date',     
        'instructor',     
        'company',     
        'hours',     
    ];

    //protected $dates = ['expedition_date'];

    // protected $casts = [
    //     'expedition_date' => 'date:d-m-Y',
    // ];
    public $timestamps = false;
    
}
