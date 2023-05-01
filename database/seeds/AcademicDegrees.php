<?php

use Illuminate\Database\Seeder;

class AcademicDegrees extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('academic_degrees')->insert(array(

            array(
                'name' => 'No aplica',
                'status' => '1',
            ),
            array
            (
                'name' => 'Sin estudios',
                'status' => '1',
            ),
            array(
                'name' => 'Primaria',
                'status' => '1',
            ),
            array
            (
                'name' => 'Tecnico',
                'status' => '1',
            ),
            array(
                'name' => 'Tecnólogo',
                'status' => '1',
            ),
            array
            (
                'name' => 'Ingeniero',
                'status' => '1',
            )
            
            
        ));
    }
}
