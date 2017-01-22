<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersInformation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_information', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userId')->unsigned();
            $table->string('firstName', 100);
            $table->string('lastName', 100);
            $table->string('organization');
            $table->string('position');
            $table->string('phone')->nullable();
            $table->boolean('isActive')->nullable();;
            $table->string('creator');
            $table->timestamp('creationDate');

            $table->foreign('userId')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
