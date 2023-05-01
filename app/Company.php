<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nit',
        'company_name',
        'address',
        'phone_number',
        'website',
        'email',
        'accounting_contact_name',
        'accounting_contact_email',
        'accounting_contact_phone',
        'humanresources_contact_name',
        'humanresources_contact_email',
        'humanresources_contact_phone',
        'country_id',
        'creation_date',
        'town_id',
        'status',
        'legal_agent',
        'arl',
        'sector_economico'
    ];

    protected $dates = ['deleted_at'];

    public function companyAdministrator()
    {
        return $this->hasOne('App\CompanyAdministrator');
    }

    public function employees()
    {
        return $this->hasMany('App\Employee');
    }



}
