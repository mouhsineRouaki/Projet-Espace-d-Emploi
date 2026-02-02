<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nom' => $this->faker->lastName(),
            'prenom' => $this->faker->firstName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'biographie' => $this->faker->paragraph(),
            'image' => null,
            'role' => $this->faker->randomElement(['RECRUTEUR', 'RECHERCHEUR']),
        ];
    }
}
