<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SkillFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nom' => ucfirst($this->faker->unique()->word()),
        ];
    }
}
