<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreFieldToSmStudent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sm_students', function (Blueprint $table) {
            //
            $table->string('current_occupation_student')->nullable();
            $table->string('facebook_student')->nullable();

            $table->unsignedBigInteger('student_family_id')->nullable();
            $table->foreign('student_family_id')->references('id')->on('sm_students_family');

            $table->unsignedBigInteger('student_permanent_id')->nullable()->unsigned();
            $table->foreign('student_permanent_id')->references('id')->on('sm_students_permanent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sm_students', function (Blueprint $table) {
            //
        });
    }
}
