<?php

namespace Database\Seeders;

use App\Models\JobVacancy;
use App\Models\User;
use App\Models\VacancyResponse;
use Illuminate\Database\Seeder;

class VacancyResponseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::all();
        JobVacancy::all()->each(function ($jobVacancy) use ($user) {
            for ($x = 0; $x < rand(1, 3); $x++) {
                $jobVacancy->vacancyResponses()->save(
                    VacancyResponse::factory()->for($jobVacancy)->for($user->random())->create()
                );
            }
        });
        VacancyResponse::all()->each(function ($vacancyResponse) use ($user) {
            for ($x = 0; $x < rand(1, 50); $x++)
                $vacancyResponse->addLike($user->random()->id);
        });
    }
}
