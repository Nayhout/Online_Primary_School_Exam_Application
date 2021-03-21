<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmSemesterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sm_semester', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('semester_code')->nullable();
            $table->string('semester_name')->nullable();
            $table->string('semester_name_kh')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('created_by')->nullable()->unsigned();
            $table->integer('updated_by')->nullable()->unsigned();
            $table->tinyInteger('active_status')->default(1);
            $table->timestamps();


            $table->integer('academic_year_id')->nullable()->default(1)->unsigned();
            $table->foreign('academic_year_id')->references('id')->on('sm_academic_years')->onDelete('restrict');

            $table->integer('school_id')->nullable()->default(1)->unsigned();
            $table->foreign('school_id')->references('id')->on('sm_schools')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sm_semester');
    }
}
