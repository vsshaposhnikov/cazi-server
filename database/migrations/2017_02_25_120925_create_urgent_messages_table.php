<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUrgentMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('urgent_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 100);
            $table->string('content');
            $table->timestamp('createDate');
            $table->string('creator');
            $table->boolean('isPublished');
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
