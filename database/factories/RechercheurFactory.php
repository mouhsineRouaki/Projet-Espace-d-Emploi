<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RechercheurFactory extends Factory
{
    public function definition(): array
    {
        return [
            'titre_profil' => $this->faker->jobTitle(),
            'specialite' => $this->faker->randomElement([
                'Laravel', 'Java', 'Comptabilité', 'Marketing', 'Réseaux'
            ]),
            'ville' => $this->faker->city(),
            'cv_path' => null,
        ];
    }
}
