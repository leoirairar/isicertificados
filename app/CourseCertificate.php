<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseCertificate extends Model
{
    protected $fillable = [
        'enrollments_id', 
        'grade', 
        'statement',
        'status',
        'expedition_date',        
        'isi_code_certification',        
    ];
}
