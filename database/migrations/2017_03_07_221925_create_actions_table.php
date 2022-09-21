<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->unique();
            $table->longText('description');
            $table->longText('howto');
            $table->boolean('allow_proposals');
            $table->enum('proposal_posters', ['admin', 'general']);
            $table->boolean('allow_comments');
            $table->boolean('allow_polls');
            $table->boolean('allow_works');
            $table->boolean('allow_newvents');
            $table->string('avatar')->default('/images/action.jpg');
            $table->integer('admin_id')->unsigned()->nullable();
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('set null');
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
        Schema::drop('actions');
    }
}
