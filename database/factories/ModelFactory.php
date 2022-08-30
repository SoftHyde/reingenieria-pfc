<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
        'role' => 'general',
        'ban_reason' => null,
    ];
});

$factory->define(App\Action::class, function (Faker\Generator $faker) {
    return [
        'title' 		    => $faker->sentence,
    	'description' 	    => $faker->text,
        'howto'             => $faker->text,
    	'admin_id'		    => 1,
    	'allow_proposals'         => 1,
        'proposal_posters'  => 'general',
        'allow_comments'          => 1,
        'allow_polls'             => 1,
        'allow_works'             => 1,
        'allow_newvents'          => 1
    ];
});

$factory->define(App\Proposal::class, function (Faker\Generator $faker) {
    return [
        'title'         => $faker->sentence,
        'content'       => $faker->text,
        'action_id'     => rand(3,6),
        'user_id'    => rand(2,10)
    ];
});

$factory->define(App\Work::class, function (Faker\Generator $faker) {
    return [
        'title'         => $faker->sentence,
        'content'       => $faker->text,
        'action_id'     => rand(2,5)
    ];
});
