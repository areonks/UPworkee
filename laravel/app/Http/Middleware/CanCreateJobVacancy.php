<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class CanCreateJobVacancy
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->coins < 2) {
            return response('Not enough coins', 402);
        }
        $createdVacancies = auth()->user()->jobVacancies()
            ->whereDate('created_at', '>', Carbon::now()->subDay()->toDateTimeString())
            ->count();
        if ($createdVacancies >= 2) {
            return response('You can not create more then 2 vacancies per 24hours', 403);
        }
        return $next($request);
    }
}
