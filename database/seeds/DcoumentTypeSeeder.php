<?php

use Illuminate\Database\Seeder;

class DcoumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('document_type')->insert(array(

            array(
                'name' => 'Cedula',
            )
            
            
        ));
    }
}
