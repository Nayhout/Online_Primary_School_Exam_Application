<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreFieldToSmParents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sm_parents', function (Blueprint $table) {
            //
            $table->date('date_of_birth_father')->nullable();
            $table->date('date_of_birth_mother')->nullable();
            $table->date('date_of_birth_guardian')->nullable();
            $table->string('location')->nullable();
            $table->string('as_guardian')->nullable();
            $table->string('father_address')->nullable();
            $table->string('mother_address')->nullable();
            $table->string('guardian_address')->nullable();
            $table->string('facebook_guardian')->nullable();
            $table->integer('emergency_contact')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sm_parents', function (Blueprint $table) {
            //
        });
    }
}
