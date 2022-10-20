<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CanCreateVacancyResponse
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
        $createdResponses =  $request->route('jobVacancy')->vacancyResponses()
            ->where('user_id', '=', auth()->id())
            ->count();
        if ($createdResponses >= 2) {
            return response('You can not send more then 2 responses for a vacancy', 403);
        }
        if (auth()->user()->coins < 1) {
            return response('Not enough coins', 402);
        }

        return $next($request);
    }
}
