<?php

namespace Database\Seeders;

use App\Models\User;
use App\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'nom' => 'Rouaki',
                'prenom' => 'Mouhsine',
                'email' => 'mouhsine@gmail.com',
                'password' => Hash::make('password'),
                'biographie' => 'Compte demo.',
                'image' => 'https://intranet.youcode.ma/storage/users/profile/thumbnail/1694-1760996364.png',
                'role' => UserRole::RECRUTEUR,
                'date_creation' => now(),
                'date_modification' => now(),
            ],
            [
                'nom' => 'ayoub',
                'prenom' => 'erak',
                'email' => 'ayoub@gmail.com',
                'password' => Hash::make('password'),
                'biographie' => 'Laravel backend, APIs, PostgreSQL.',
                'image' => 'https://intranet.youcode.ma/storage/users/profile/thumbnail/1751-1760996444.png',
                'role' => UserRole::RECHERCHEUR,
                'date_creation' => now(),
                'date_modification' => now(),
            ],
        ];

        foreach ($users as $u) {
            User::create($u);
        }
    }
}
