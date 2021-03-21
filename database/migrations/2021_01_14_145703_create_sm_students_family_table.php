<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmStudentsFamilyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sm_students_family', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('family_member')->nullable();
            $table->string('family1')->nullable();
            $table->string('family2')->nullable();
            $table->string('family3')->nullable();
            $table->string('major1')->nullable();
            $table->string('major2')->nullable();
            $table->string('major3')->nullable();
            $table->string('academic1')->nullable();
            $table->string('academic2')->nullable();
            $table->string('academic3')->nullable();
            $table->string('as1')->nullable();
            $table->string('as2')->nullable();
            $table->string('as3')->nullable();
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
        Schema::dropIfExists('sm_students_family');
    }
}
