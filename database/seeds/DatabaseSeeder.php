<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::unprepared(File::get(base_path('../isi_certificados/resources/scripts/insertNewDocument.sql'))); 
        //DB::unprepared(File::get(base_path('../isi_certificados/resources/scripts/updateAcademyDegrees.sql'))); 
        //DB::unprepared(File::get(base_path('../isi_certificados/resources/scripts/holidays.sql'))); 
        //$this->call(AcademicDegrees::class);
        //$this->call(DcoumentTypeSeeder::class);
        //$this->call(CompanyTableSeeder::class);
        //$this->call(UsersTableSeeder::class);
        // DB::unprepared(File::get(base_path('../isi_certificados/resources/scripts/countries.sql'))); 
        // DB::unprepared(File::get(base_path('../isi_certificados/resources/scripts/states.sql'))); 
        // DB::unprepared(File::get(base_path('../isi_certificados/resources/scripts/academic_degrees.sql'))); 

    }
}
