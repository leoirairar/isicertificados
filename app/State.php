<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    public function countries()
    {
        return $this->belongsTo(Country::class);
    }
}
