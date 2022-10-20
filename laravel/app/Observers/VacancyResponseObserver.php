<?php

namespace App\Observers;

class VacancyResponseObserver
{
    public function created()
    {
        auth()->user()->decrement('coins');

    }
}
