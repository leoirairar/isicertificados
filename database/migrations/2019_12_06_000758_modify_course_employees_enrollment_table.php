<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyCourseEmployeesEnrollmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_employees_enrollment', function (Blueprint $table) {
            
            $table->boolean('reschedule')->default(0);
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
            
            $table->boolean('reschedule')->default(0);
        });
    }
}
