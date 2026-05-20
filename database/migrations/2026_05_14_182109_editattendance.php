<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

 class editstaff extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('staff', function (Blueprint $table) {

            //$table->dropColumn('BirthDay');
            //$table->renameColumn('Number of hours', 'Number_of_hours');
            //$table->integer('Number_of_hours')->change();
            //$table->integer('Number_of_days')->nullable()->after('Number_of_hours');
            $table->integer('mobile')->nullable()->after('Number_of_days');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('staff', function (Blueprint $table) {
            //
        });
    }
};
