<?php

namespace Database\Seeders;

use App\Models\JobVacancy;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = Tag::factory(50)->create();
        JobVacancy::all()->each(function ($jobVacancy) use ($tags) {
            $jobVacancy->tags()->sync($tags->random(rand(1, 3))->pluck('id')->toArray());
        });
    }
}
