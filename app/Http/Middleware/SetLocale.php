<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
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
        if(! $request->user()) {
            return $next($request);
        }

        if($request->user()->user_type == 2){
            app()->setLocale(session('language', 'en'));
            return $next($request);
        }
 
        $language = $request->user()->language;
 
        if (isset($language)) {
            app()->setLocale($language);
        }
 
        return $next($request);
    }
}
