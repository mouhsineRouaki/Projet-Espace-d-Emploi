<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FormationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'diplome' => $this->faker->randomElement(['Licence', 'Master', 'Doctorat']),
            'ecole' => $this->faker->company(),
            'annee_obtention' => $this->faker->year(),
            'description' => $this->faker->sentence(),
        ];
    }
}
