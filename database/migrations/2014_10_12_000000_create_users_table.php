<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('last_name');
            $table->string('identification_number');
            $table->string('document_type')->default('CC')->comment('it will use three type of users: CC, CE,');
            $table->string('email')->unique();
            $table->string('phone_number');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->char('role', 1)->default('E')->comment('it will use three type of users: M(master ISI), E(employee),T(trainer),I(Independent worker),A(administrator) and S(super admin)')->nullable(false);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->bigInteger('company_id');
            $table->date('birthdate');
            $table->bigInteger('academy_degree_id');
            $table->string('position');
            $table->string('emergency_contact_name');
            $table->string('emergency_phone_number');
            $table->timestamps();

        });

        Schema::create('company_administrator', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->bigInteger('company_id');
            $table->string('position');
            $table->timestamps();
        });

        Schema::create('instructors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
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
        Schema::dropIfExists('users');
        Schema::dropIfExists('employees');
        Schema::dropIfExists('company_administrator');
        Schema::dropIfExists('instructors');
    }
}
