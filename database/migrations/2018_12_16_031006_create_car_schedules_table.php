<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CarSchedules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('car_id')->unsigned();
            $table->dateTime('start');
            $table->dateTime('end');
            $table->timestamps();

            $table->foreign('car_id')->references('id')->on('Cars')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('CarSchedules', function($table) {
            $table->dropForeign(['car_id']);
        });
        
        Schema::dropIfExists('CarSchedules');
    }
}
