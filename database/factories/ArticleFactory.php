<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'description' => $this->faker->text(1000),
            'user_id_created' => '1',
            'status' => $this->faker->randomElement(['En Revision', 'Factible', 'No Factible']),
            'project_id' =>  rand(1,10),
        ];
    }
}
