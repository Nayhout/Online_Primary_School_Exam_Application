<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreFieldToSmStudentCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sm_student_categories', function (Blueprint $table) {
            //
            $table->integer('percentage')->nullable();
            $table->string('categories_description')->nullable();
            $table->string('fix_amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sm_student_categories', function (Blueprint $table) {
            //
        });
    }
}
