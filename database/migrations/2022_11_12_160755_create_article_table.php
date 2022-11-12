<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article', function (Blueprint $table) {
            $table->increments('id');
            $table->longtext('desx');
            $table->integer('user_id_created')->unsigned();
            $table->foreign('user_id_created')->references('id')->on('users')->onDelete('cascade');
            $table->enum('status',['En Revision', 'Factible', 'No Factible'])->default('En Revision');
            $table->integer('project_id')->unsigned();
            $table->foreign('project_id')->references('id')->on('project')->onDelete('cascade');            
            $table->longText('closing_message')->nullable()->default(null);
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
        Schema::dropIfExists('article');
    }
};
