<?php

namespace App\Providers;

use App\Models\JobVacancy;
use App\Models\VacancyResponse;
use App\Policies\VacancyResponsePolicy;
use App\Policies\JobVacancyPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        JobVacancy::class => JobVacancyPolicy::class,
        VacancyResponse::class => VacancyResponsePolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
