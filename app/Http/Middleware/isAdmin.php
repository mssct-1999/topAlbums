<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

// Middleware vérifiant si un utilisateur est admin et peut accéder à une ressource ou effectuer une action.
class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (User::isAdmin(\Auth::user())) {
            return $next($request);
        }
        return back();
    }
}
