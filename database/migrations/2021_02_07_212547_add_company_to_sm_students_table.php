<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompanyToSmStudentsTable extends Migration
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
            $table->text('company')->nullable();

            $table->unsignedBigInteger('emergency_contact_id')->nullable();
            $table->foreign('emergency_contact_id')->references('id')->on('emergency_contact');

            $table->unsignedBigInteger('generation_id')->nullable();
            $table->foreign('generation_id')->references('id')->on('sm_generation');
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
