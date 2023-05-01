<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nit')->unique();
            $table->string('company_name');
            $table->string('address');
            $table->string('phone_number')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->bigInteger('country_id')->unsigned()->index();
            $table->bigInteger('town_id');
            $table->date('creation_date');
            $table->boolean('status');
            $table->timestamps();

        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
