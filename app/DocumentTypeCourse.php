<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentTypeCourse extends Model
{
    protected $table = 'document_type_by_course';

    protected $fillable = [
        'document_type_id', 
    ];

    public function course()
    {
        return $this->belongsTo('App\Course','course_id','id');
    }

    public function documentType()
    {
        return $this->belongsTo('App\DocumentType','document_type_id','id');
    }


}
