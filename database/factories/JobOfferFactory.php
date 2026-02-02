<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class JobOfferFactory extends Factory
{
    public function definition(): array
    {
        return [
            'type_contrat' => $this->faker->randomElement(['CDI', 'CDD', 'Stage', 'Freelance']),
            'titre' => $this->faker->jobTitle(),
            'description' => $this->faker->paragraph(5),
            'image' => 'default.png',
            'ville' => $this->faker->city(),
            'is_closed' => false,
        ];
    }
}
