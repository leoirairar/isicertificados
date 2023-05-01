<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldReprogrammingCourseEmployeesEnrollment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_employees_enrollment', function (Blueprint $table) {
            $table->boolean('reprogrammed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_employees_enrollment', function (Blueprint $table) {
            $table->boolean('reprogrammed')->default(0);
        });
    }
}
