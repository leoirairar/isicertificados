<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Files extends Model
{

    protected $fillable = [
        'employee_id',
        'file_id', 
        'fileroute', 
        'name',
        'status'      
    ];

    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }

    public function documentType()
    {
        return $this->belongsTo('App\DocumentType','file_id');
    }

    
}
