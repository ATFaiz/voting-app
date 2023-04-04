<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;


class TimeRestrictionMiddleware
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
        $startTime = Carbon::parse('2023-03-30 01:00:00'); // set start time here
        $endTime = Carbon::parse('2023-03-30 23:30:00'); // set end time here
        $currentTime = Carbon::now();
        $currentDate = $currentTime->toDateString();
    
        if ($currentDate === $startTime->toDateString()
         && $currentTime->between($startTime, $endTime)) {
            return $next($request);
        } else {
            $message = 'Access denied: Route only available between 8:00 AM and 8:00 PM on March 20, 2023';
            return response()->view('errors.time-restriction', ['message' => $message], 403)
                ->header('Refresh', '15;url=' . route('home'));
        }
    }
    

    
}
