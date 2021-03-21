<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDepartmentIdToSmDesignations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sm_designations', function (Blueprint $table) {
            $table->integer('department_id')->nullable()->unsigned();
            $table->foreign('department_id')->references('id')->on('sm_human_departments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sm_designations', function (Blueprint $table) {
            //
        });
    }
}
