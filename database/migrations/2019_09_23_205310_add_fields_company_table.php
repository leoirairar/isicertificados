<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('accounting_contact_name')->after('email');
            $table->string('accounting_contact_email')->after('accounting_contact_name');
            $table->string('accounting_contact_phone')->after('accounting_contact_email');
            $table->string('humanresources_contact_name')->after('accounting_contact_phone');
            $table->string('humanresources_contact_email')->after('humanresources_contact_name');
            $table->string('humanresources_contact_phone')->after('humanresources_contact_email');
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
            $table->string('accounting_contact_name');
            $table->string('accounting_contact_email');
            $table->string('accounting_contact_phone');
            $table->string('humanresources_contact_name');
            $table->string('humanresources_contact_email');
            $table->string('humanresources_contact_phone');
        });
    }
}
