<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmWeekendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sm_weekends', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->integer('order')->nullable();
            $table->integer('is_weekend')->nullable();
            $table->integer('active_status')->default(1);
            $table->timestamps();
        });

        DB::table('sm_weekends')->insert([
            [
                'name' => 'Saturday',
                'order' => 1,
                'is_weekend' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Sunday',
                'order' => 2,
                'is_weekend' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Monday',
                'order' => 3,
                'is_weekend' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Tuesday',
                'order' => 4,
                'is_weekend' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Wednesday',
                'order' => 5,
                'is_weekend' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Thursday',
                'order' => 6,
                'is_weekend' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Friday',
                'order' => 7,
                'is_weekend' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sm_weekends');
    }
}
