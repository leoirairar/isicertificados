<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentType extends Model
{
    protected $table = 'document_type';

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 
      
    ];


    public function coruses()
    {
        return $this->belongsToMany('App\Course','document_type_by_course','document_type_id','course_id');
    }

    public function files()
    {
        return $this->hasMany('App\Files','file_id','id');
    }

    
}
