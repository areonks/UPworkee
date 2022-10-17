<?php

namespace App\Observers;

use App\Models\JobVacancy;

class JobVacancyObserver
{
    public function deleted(JobVacancy $jobVacancy)
    {
        $jobVacancy->tags()->detach();
        $jobVacancy->likedUsers()->detach();
    }
}
