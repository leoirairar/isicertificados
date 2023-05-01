<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'course_code',
        'description',
        'revalidable',
        'status',
        'prefix',
        'type',
    ];

    protected $dates = ['deleted_at'];

    public function courseProgramming()
    {
        return $this->hasMany('App\CourseProgramming');
    }

    public function documentsType()
    {
        return $this->belongsToMany('App\DocumentType','document_type_by_course','course_id','document_type_id');
    }

    public function consecutive()
    {
        return $this->hasOne('App\Consecutive');
    }
}
