<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDegreeStringToSmTemporaryMeritlistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sm_temporary_meritlists', function (Blueprint $table) {
            //
            $table->string('grades_id_string',250)->nullable();
            $table->string('grades_string',250)->nullable();
            $table->string('type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sm_temporary_meritlists', function (Blueprint $table) {
            //
        });
    }
}
