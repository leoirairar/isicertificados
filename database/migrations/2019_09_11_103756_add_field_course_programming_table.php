<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldCourseProgrammingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_programming', function (Blueprint $table) {
            $table->tinyInteger('quantity_enrolled_employees')->after('place')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_programming', function (Blueprint $table) {
            $table->tinyInteger('quantity_enrolled_employees')->after('place')->default(0);
        });
    }
}
