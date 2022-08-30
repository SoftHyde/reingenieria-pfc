<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
Use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\User>
 */
class ActionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' 		    => $this->faker->sentence(),
            'description' 	    => $this->faker->text(),
            'howto'             => $this->faker->text(),
            'admin_id'		    => 1,
            'allow_proposals'         => 1,
            'proposal_posters'  => 'general',
            'allow_comments'          => 1,
            'allow_polls'             => 1,
            'allow_works'             => 1,
            'allow_newvents'          => 1
        ];
    }
}