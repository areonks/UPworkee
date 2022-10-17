<?php

namespace Database\Seeders;

use App\Models\JobVacancy;
use App\Models\User;
use Illuminate\Database\Seeder;

class JobVacancySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::all();
        $user->each(function ($user) {
            $user->jobVacancies()->saveMany(
                JobVacancy::factory()->count(rand(0, 2))->for($user)->create()
            );
        });
        JobVacancy::all()->each(function ($jobVacancy) use ($user) {
            for ($x = 0; $x < rand(1, 20); $x++)
                $jobVacancy->addLike($user->random()->id);
        });
    }
}
