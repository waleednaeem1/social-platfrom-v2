<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RedirectToWWW
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        // Check if the request's host is not "www.vtfriends.com"
        if ($request->getHost() === 'vtfriends.com') {
            // Redirect to the www subdomain
            return Redirect::away('https://www.vtfriends.com'.$request->getRequestUri());
        }

        return $next($request);
    }
}
