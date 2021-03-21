<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmMajorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sm_majors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('major_code')->nullable();
            $table->string('major_name')->nullable();
            $table->string('major_name_kh')->nullable();
            $table->string('description')->nullable();
            $table->integer('created_by')->nullable()->unsigned();
            $table->integer('updated_by')->nullable()->unsigned();
            $table->tinyInteger('active_status')->default(1);
            $table->timestamps();

            $table->integer('school_id')->nullable()->default(1)->unsigned();
            $table->foreign('school_id')->references('id')->on('sm_schools')->onDelete('restrict');

            $table->bigInteger('faculty_id')->nullable()->unsigned();
            $table->foreign('faculty_id')->references('id')->on('sm_faculty')->onDelete('restrict');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sm_majors');
    }
}
