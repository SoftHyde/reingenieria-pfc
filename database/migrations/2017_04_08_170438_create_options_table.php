<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
class CreateOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('options', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('proposal_id')->unsigned()->nullable();
            $table->foreign('proposal_id')->references('id')->on('proposals')->onDelete('set null');

            $table->integer('poll_id')->unsigned();
            $table->foreign('poll_id')->references('id')->on('polls')->onDelete('cascade');

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
        Schema::drop('options');
    }
}
