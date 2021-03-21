<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAssignIdToSmToDosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sm_to_dos', function (Blueprint $table) {
            //
            $table->string('description')->nullable();
            $table->date('due_date')->nullable();

            $table->unsignedBigInteger('assign_staff_id')->nullable();
//            $table->foreign('assign_staff_id')->references('id')->on('sm_staffs');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sm_to_dos', function (Blueprint $table) {
            //
        });
    }
}
