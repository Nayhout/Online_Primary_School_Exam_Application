<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddClassRoomIdToSmClasses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sm_classes', function (Blueprint $table) {
            //
            $table->integer('class_room_id')->nullable()->unsigned();
            $table->foreign('class_room_id')->references('id')->on('sm_class_rooms');

            $table->unsignedBigInteger('degree_id')->nullable();
            $table->foreign('degree_id')->references('id')->on('sm_degrees');

            $table->unsignedBigInteger('faculty_id')->nullable();
            $table->foreign('faculty_id')->references('id')->on('sm_faculty');

            $table->unsignedBigInteger('majors_id')->nullable();
            $table->foreign('majors_id')->references('id')->on('sm_majors');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sm_classes', function (Blueprint $table) {
            //
        });
    }
}
