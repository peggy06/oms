<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->integer('under_to')->nullable();
            $table->string('password');
            $table->integer('deleted')->nullable();
            $table->integer('accepted')->nullable();
            $table->integer('confirmed')->nullable();
            $table->integer('isOnline')->nullable();
            $table->integer('onDuty')->nullable();
            $table->integer('role');
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
