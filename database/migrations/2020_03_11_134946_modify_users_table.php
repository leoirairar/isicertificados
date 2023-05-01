<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_number')->nullable()->change();
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->string('birthdate')->nullable()->change();
            $table->string('position')->nullable()->change();
            $table->string('emergency_contact_name')->nullable()->change();
            $table->string('emergency_phone_number')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_number')->nullable()->change();
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->string('birthdate')->nullable()->change();
            $table->string('position')->nullable()->change();
            $table->string('emergency_contact_name')->nullable()->change();
            $table->string('emergency_phone_number')->nullable()->change();
        });
    }
}
