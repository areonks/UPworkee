<?php

namespace App\Observers;

class VacancyResponseObserver
{
    public function created()
    {
        if (auth()->user()) {
            auth()->user()->decrement('coins');
        }
    }
}
