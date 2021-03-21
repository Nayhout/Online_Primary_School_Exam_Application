<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmStudentsPermanentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sm_students_permanent', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('house_permanent')->nullable();
            $table->string('street_permanent')->nullable();
            $table->string('group_permanent')->nullable();
            $table->string('village_permanent')->nullable();
            $table->string('commune_permanent')->nullable();
            $table->string('district_permanent')->nullable();
            $table->string('province_permanent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sm_students_permanent');
    }
}
