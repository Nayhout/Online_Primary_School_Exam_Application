<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmPickupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sm_pickups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pickup_no')->nullable();
            $table->string('first_name', 100)->nullable();
            $table->string('last_name', 100)->nullable();
            $table->string('khmer_name',100)->nullable();
            $table->string('full_name', 200)->nullable();
            $table->date('date_of_birth')->nullable()->default(date('Y-m-d'));
            $table->string('email', 50)->nullable();
            $table->string('mobile', 50)->nullable();
            $table->string('emergency_mobile', 50)->nullable();
            $table->string('pickup_photo')->nullable();
            $table->string('current_address', 500)->nullable();
            $table->string('permanent_address', 500)->nullable();
            $table->string('location', 50)->nullable();
            $table->string('facebook_url', 100)->nullable();
            $table->string('twiteer_url', 100)->nullable();
            $table->string('linkedin_url', 100)->nullable();
            $table->string('instragram_url', 100)->nullable();
            $table->string('other_document', 500)->nullable();
            $table->string('notes', 500)->nullable();
            $table->tinyInteger('active_status')->default(1);
            $table->timestamps();

            $table->integer('user_id')->nullable()->unsigned()->default(1);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');

            $table->integer('gender_id')->nullable()->unsigned()->default(1);
            $table->foreign('gender_id')->references('id')->on('sm_base_setups')->onDelete('restrict');

            $table->integer('student_id')->nullable()->unsigned()->default(1);
            $table->foreign('student_id')->references('id')->on('sm_students')->onDelete('restrict');


            $table->integer('created_by')->nullable()->default(1)->unsigned();
            $table->integer('updated_by')->nullable()->default(1)->unsigned();

            $table->integer('school_id')->nullable()->default(1)->unsigned();
            $table->foreign('school_id')->references('id')->on('sm_schools')->onDelete('restrict');
        });


//        DB::table('sm_pickups')->insert([
//            [
//                'staff_no'       => '1',
//                'first_name'       => 'Super',
//                'last_name'        => 'Admin',
//                'full_name'        => 'Super Admin',
//                'email'            => 'admin@gmail.com',
//                'created_at' => date('Y-m-d h:i:s')
//            ]
//        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sm_pickups');
    }
}
