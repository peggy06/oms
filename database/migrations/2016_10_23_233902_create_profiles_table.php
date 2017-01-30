<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->text('avatar')->nullable();
            $table->timestamp('bday')->nullable();
            $table->time('sched_on')->nullable();
            $table->time('sched_off')->nullable();
            $table->integer('gender')->nullable();
            $table->text('course')->nullable();
            $table->text('section')->nullable();
            $table->text('contact')->nullable();
            $table->integer('company_id')->nullable();
            $table->integer('number_of_hours_rendered')->nullable();
            $table->text('technology_area')->nullable();
            $table->string('company_supervisor')->nullable();
            $table->string('company_contact')->nullable();
            $table->integer('deleted')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('profiles');
    }
}
