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
<<<<<<< HEAD:database/migrations/2026_05_14_182109_edit_attendance.php
        Schema::table('edit_attendance', function (Blueprint $table) {

            $table->renameColumn('user_id', 'staff_id');

=======
        Schema::table('staff', function (Blueprint $table) {
>>>>>>> 3d77f47c8c867125350c583111b345127b5b1bf0:database/migrations/2026_05_14_182109_editstaff.php

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
<<<<<<< HEAD:database/migrations/2026_05_14_182109_edit_attendance.php
        Schema::table('edit_attendance', function (Blueprint $table) {
=======
        Schema::table('staff', function (Blueprint $table) {
>>>>>>> 3d77f47c8c867125350c583111b345127b5b1bf0:database/migrations/2026_05_14_182109_editstaff.php
            //
        });
    }
};
