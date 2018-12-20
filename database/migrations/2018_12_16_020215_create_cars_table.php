<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Cars', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('registration_no')->unique();
            $table->string('build');
            $table->string('model');
            $table->string('year');
            $table->json('location');
            $table->boolean('is_featured')->default(false);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('Users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('Cars', function($table) {
            $table->dropForeign(['user_id']);
        });
        
        Schema::dropIfExists('Cars');
    }
}
