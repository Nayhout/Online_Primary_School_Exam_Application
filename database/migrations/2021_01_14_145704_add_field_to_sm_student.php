<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldToSmStudent extends Migration
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
            $table->string('house_student')->nullable();
            $table->string('street_student')->nullable();
            $table->string('group_student')->nullable();
            $table->string('village_student')->nullable();
            $table->string('commune_student')->nullable();
            $table->string('district_student')->nullable();
            $table->string('province_student')->nullable();
            $table->string('village_school')->nullable();
            $table->string('commune_school')->nullable();
            $table->string('district_school')->nullable();
            $table->string('from_school')->nullable();
            $table->string('province_school')->nullable();
            $table->string('degree_year')->nullable();
            $table->string('degree_no')->nullable();
            $table->string('subject1')->nullable();
            $table->string('subject2')->nullable();
            $table->string('subject3')->nullable();
            $table->string('subject4')->nullable();
            $table->string('subject5')->nullable();
            $table->string('subject6')->nullable();
            $table->string('total_grade')->nullable();
            $table->integer('total_score')->nullable();
            $table->string('degree_level')->nullable();
            $table->string('grade1')->nullable();
            $table->string('grade2')->nullable();
            $table->string('grade3')->nullable();
            $table->string('grade4')->nullable();
            $table->string('grade5')->nullable();
            $table->string('grade6')->nullable();
            $table->string('house_birth')->nullable();
            $table->string('group_birth')->nullable();
            $table->string('village_birth')->nullable();
            $table->string('commune_birth')->nullable();
            $table->string('district_birth')->nullable();
            $table->string('city')->nullable();
            $table->string('document_title_5')->nullable();
            $table->string('document_file_5')->nullable();
            $table->tinyInteger('external')->nullable();
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
