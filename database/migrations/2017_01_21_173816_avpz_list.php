<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AvpzList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avpz_list', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 100);
            $table->string('downloadLink');
            $table->string('downloadLinkExe');
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
