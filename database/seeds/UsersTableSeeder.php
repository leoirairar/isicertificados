<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(array(

            array(
                'name' => 'admin',
                'last_name' => 'nn',
                'identification_number' => '12345',
                'document_type' => 'CC',
                'email' => 'admin@correo.com',
                'email_verified_at' => null,
                'role' => 'S',
                'phone_number'=>'12345685',
                'password' => '$2y$10$2ezU4ISpe/lFQDltdIbzOOYnhg2V3ZcVJP878lVj9Cz0WoS0VgXWq',
            ),
            array
            (
                'name' => 'Ruben',
                'last_name' => 'nn',
                'identification_number' => '12345',
                'document_type' => 'CC',
                'email' => 'rubendhoyos@gmail.com',
                'email_verified_at' => null,
                'role' => 'M',
                'phone_number'=>'12345685',
                'password' => '$2y$10$b.Kz1EjGTTSOPbjKYa2kjOuB6Ugj.taPchlONqU7jnLLSEbAFGlhG',
            )
            
            
        ));
    }
}
