<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyCompanyEmployTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('sector_economico')->nullable();
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->string('sector_economico')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('sector_economico')->nullable();
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->string('sector_economico')->nullable();
        });
    }
}
