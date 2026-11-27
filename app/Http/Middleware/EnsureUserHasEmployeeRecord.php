<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasEmployeeRecord
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()->employee) {
            return redirect()->route('dashboard')->withErrors(['message' => __('messages.attendance.no_employee_record')]);
        }

        return $next($request);
    }
}
