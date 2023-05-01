<?php

use Illuminate\Database\Seeder;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert(array(

            array(
                "id" =>	'0',
                "nit" =>	'900664067',
                "company_name" =>	'ISI Ingeniería en Seguridad Industrial S.A.S',
                "address" =>	'Calle 26 # 41-140',
                "phone_number" =>	'3728637',
                "website" =>	'isiseguridadindustrial.com',
                "email" =>	'servicios@isiseguridadindustrial.com',
                "accounting_contact_name" =>	'Marcela Gutierrez',	
                "accounting_contact_email" =>	'servicios@isiseguridadindustrial.com',	
                "accounting_contact_phone" =>	'3728637',
                "humanresources_contact_name" =>	'Marcela Gutierrez',
                "humanresources_contact_email" =>	'servicios@isiseguridadindustrial.com',
                "humanresources_contact_phone" =>	'3728637',
                "country_id" =>	'44',
                "town_id" =>	'685',
                "creation_date" =>	'2019-09-04',
                "status" =>	1	,
                "created_at" =>	'2019-09-04',
                "updated_at" =>	'2019-09-04',
                "deleted_at" =>	'2019-09-04',
                "terms_conditions" => 1,
                "habeas_data" => 1
            )
            
            
        ));
    }
}


