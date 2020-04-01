<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class verifyadmin extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::guard('admin')->user();
        if ($user == null) {
            abort(403, 'Unauthorized action.');
        } else {
            if ($user->type != 'admin') {
                abort(403, 'Unauthorized action.');
            }
            return $next($request);
        }
    }
}
