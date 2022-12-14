<?php

namespace App\Observers;

use App\Models\JobVacancy;

class JobVacancyObserver
{
    public function created()
    {
        if(auth()->user()) {
            auth()->user()->decrement('coins', 2);
        }
    }

    public function deleted(JobVacancy $jobVacancy)
    {
        $jobVacancy->tags()->detach();
        $jobVacancy->likedUsers()->detach();
    }
}
