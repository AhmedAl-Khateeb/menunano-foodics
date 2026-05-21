<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

 class editAttendance extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('edit_attendance', function (Blueprint $table) {

            $table->renameColumn('user_id', 'staff_id');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('edit_attendance', function (Blueprint $table) {
            //
        });
    }
};
