<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RecruteurFactory extends Factory
{
    public function definition(): array
    {
        return [
            'entreprise' => $this->faker->company(),
            'site_web' => $this->faker->url(),
            'telephone' => $this->faker->phoneNumber(),
            'ville' => $this->faker->city(),
            'adresse' => $this->faker->address(),
            'description_entreprise' => $this->faker->paragraph(),
        ];
    }
}
