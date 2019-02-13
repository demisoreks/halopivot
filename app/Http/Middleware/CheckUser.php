<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Controllers\LoginController;
use Redirect;

class CheckUser
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
        if (!LoginController::checkAccess()) {
            return Redirect::route('welcome')
                    ->with('error', '<strong>Access denied!</strong><br />Please log in to gain access.');
        }
        
        return $next($request);
    }
}
