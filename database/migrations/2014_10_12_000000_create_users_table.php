<?php

use Illuminate\Support\Facades\Schema;
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
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('avatar')->default('/images/profile.jpg');
            $table->string('password', 60);
            $table->enum('role', ['general', 'admin', 'action_admin'])->default('general');
            $table->string('registration_token')->nullable();
            $table->longText('ban_reason')->nullable()->default(null);
            $table->boolean('email_notification')->default(0);
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
        //DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::drop('users');
    }
}
