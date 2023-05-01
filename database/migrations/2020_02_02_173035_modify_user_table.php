<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('literacy_level')->nullable();
            $table->string('hemo_classification')->nullable();
            $table->string('allergies')->nullable();
            $table->string('recent_medication_use')->nullable();
            $table->string('recent_Injuries')->nullable();
            $table->string('current_diseases')->nullable();
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
            $table->string('literacy_level')->nullable();
            $table->string('hemo_classification')->nullable();
            $table->string('allergies')->nullable();
            $table->string('recent_medication_use')->nullable();
            $table->string('recent_Injuries')->nullable();
            $table->string('current_diseases')->nullable();
        });
    }
}
