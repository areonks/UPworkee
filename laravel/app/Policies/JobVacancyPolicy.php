<?php

namespace App\Policies;

use App\Models\JobVacancy;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class JobVacancyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\JobVacancy  $jobVacancy
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, JobVacancy $jobVacancy )
    {
        return $user->id === $jobVacancy->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\JobVacancy  $jobVacancy
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function destroy(User $user, JobVacancy $jobVacancy)
    {
        return $user->id === $jobVacancy->user_id;
    }

}
