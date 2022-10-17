<?php

namespace App\Repositories;

interface JobVacancyRepositoryInterface
{
    public function getAll(array $searchParams);
}
