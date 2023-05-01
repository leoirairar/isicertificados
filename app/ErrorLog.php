<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ErrorLog extends Model
{
    use SoftDeletes;

    protected $table = 'error_logs';

    protected $fillable = [
        'message',
        'code_line', 
        'class', 
        'class_function'    
    ];



}
