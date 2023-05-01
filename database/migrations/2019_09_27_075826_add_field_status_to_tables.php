<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldStatusToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        

        Schema::table('course_programming', function (Blueprint $table) {
            $table->boolean('status')->after('quantity_enrolled_employees')->default(0);
        });

        Schema::table('course_days', function (Blueprint $table) {
            $table->boolean('status')->after('date')->default(0);
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
            $table->boolean('status')->after('quantity_enrolled_employees')->default(0);
        });

        Schema::table('course_days', function (Blueprint $table) {
            $table->boolean('status')->after('date')->default(0);
        });
    }
}
