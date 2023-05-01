<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldGroupCourseprogramingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_programming', function (Blueprint $table) {
            $table->string('group')->default(0);
            $table->boolean('gropu_cheked')->default(0);
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
            $table->string('group')->default(0);
            $table->boolean('gropu_cheked')->default(0);
        });
    }
}
