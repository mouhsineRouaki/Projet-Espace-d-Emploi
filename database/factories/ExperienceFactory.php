<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ExperienceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'poste' => $this->faker->jobTitle(),
            'entreprise' => $this->faker->company(),
            'date_debut' => $this->faker->date(),
            'date_fin' => null,
            'en_poste' => true,
            'description' => $this->faker->paragraph(),
        ];
    }
}
