<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Recruteur;
use App\Models\Rechercheur;
use App\Models\Skill;
use App\Models\JobOffer;
use App\Models\Application;
use App\Models\Formation;
use App\Models\Experience;
use App\Models\Relationship;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
       $skills = Skill::factory()->count(10)->create(); 

        $users = User::factory()->count(20)->create();

        $recruteurs = $users->where('role', 'RECRUTEUR')->each(function ($user) {
            Recruteur::factory()->create([
                'user_id' => $user->id,
            ]);
        });

        $rechercheurs = $users->where('role', 'RECHERCHEUR')->each(function ($user) use ($skills) {
            $rechercheur = Rechercheur::factory()->create([
                'user_id' => $user->id,
            ]);

            $rechercheur->skills()->attach(
                $skills->random(rand(2, 5))->pluck('id')->toArray(),
                ['niveau' => 'intermédiaire']
            );

            Formation::factory()->count(2)->create([
                'rechercheur_user_id' => $user->id,
            ]);

            Experience::factory()->count(2)->create([
                'rechercheur_user_id' => $user->id,
            ]);
        });

        Recruteur::all()->each(function ($recruteur) {
            JobOffer::factory()->count(3)->create([
                'recruteur_user_id' => $recruteur->user_id,
            ]);
        });

        $jobOffers = JobOffer::all();
        Rechercheur::all()->each(function ($rechercheur) use ($jobOffers) {
            Application::create([
                'job_offer_id' => $jobOffers->random()->id,
                'rechercheur_user_id' => $rechercheur->user_id,
                'status' => 'PENDING',
            ]);
        });
        $users->each(function ($user) use ($users) {
            $friend = $users->where('id', '!=', $user->id)->random();

            Relationship::firstOrCreate([
                'sender_id' => $user->id,
                'reciever_id' => $friend->id,
            ]);
        });
    }
}
