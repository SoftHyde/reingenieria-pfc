<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
Use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\User>
 */
class WorkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
    
        return [
                    'title'         => $this->faker->sentence(),
                    'content'       => $this->faker->text(),
                    'action_id'     => rand(2,5)
                ];
    }
}