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
            $table->string('login');
            $table->string('password', 60);
            $table->string('email');
            $table->string('role');
            $table->string('firstName', 100);
            $table->string('lastName', 100);
            $table->string('organization');
            $table->string('position');
            $table->string('phone')->nullable();
            $table->string('creator');
            $table->boolean('isActive')->nullable();
            $table->timestamp('lastVisit')->nullable();
            $table->timestamp('creationDate');
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
