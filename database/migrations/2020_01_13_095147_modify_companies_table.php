<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('humanresources_contact_name')->nullable()->change();
            $table->string('humanresources_contact_email')->nullable()->change();
            $table->string('humanresources_contact_phone')->nullable()->change();
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
            $table->string('humanresources_contact_name')->nullable()->change();
            $table->string('humanresources_contact_email')->nullable()->change();
            $table->string('humanresources_contact_phone')->nullable()->change();
        });
    }
}
