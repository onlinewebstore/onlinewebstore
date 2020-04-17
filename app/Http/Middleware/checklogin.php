<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;

class checklogin
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
        
        if(Auth::guard('admin')->check()||Auth::guard('buyer')->check()||Auth::guard('owner')->check()){
            abort(403, 'Unauthorized action.');    
            
        }
        return $next($request); 
    }
}
