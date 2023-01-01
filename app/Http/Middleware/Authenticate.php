<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        // if (! $request->expectsJson()) {
        //     return route('login');
        // }

        // melakukan pengecekan apakah ada header bernama key Authorization 
        // ketika melakukan request api jika tidak ada 
        // maka dinyatakan Unauthorization.
        if (!$request->expectsJson()) {
            return route('login');
        }
    }
}
