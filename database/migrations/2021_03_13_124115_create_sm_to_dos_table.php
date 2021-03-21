<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmToDosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sm_to_dos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('todo_title')->nullable();
            $table->date('date')->nullable();
            $table->enum('complete_status',['Not Started','Pending','Testing','Await Feedback','Completed'])->default('Not Started')->nullable();

            $table->integer('assign_to')->nullable()->unsigned();
            $table->foreign('assign_to')->references('id')->on('sm_staffs');

            $table->tinyInteger('active_status')->default(1);
            $table->timestamps();


$table->integer('created_by')->nullable()->default(1)->unsigned();

            $table->integer('updated_by')->nullable()->default(1)->unsigned();

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
        Schema::dropIfExists('sm_to_dos');
    }
}
