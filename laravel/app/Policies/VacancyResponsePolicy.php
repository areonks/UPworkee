<?php

namespace App\Policies;

use App\Models\VacancyResponse;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class VacancyResponsePolicy
{
    use HandlesAuthorization;

    public function update(User $user, VacancyResponse $vacancyResponse)
    {
        return $user->id === $vacancyResponse->user_id;
    }

    public function destroy(User $user, VacancyResponse $vacancyResponse)
    {
        return $user->id === $vacancyResponse->user_id;
    }
}
