<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @extends Factory
 */
class FormFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape(['name' => "string", 'description' => "string", 'user_id' => "int"])]
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text(25),
            'user_id' => 1,
        ];
    }
}
