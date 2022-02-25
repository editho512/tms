<?php

namespace App\Http\Middleware\User;

use Closure;
use Illuminate\Http\Request;

class Admin
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
        if (!auth()->user())
        {
            return redirect(null, 301)->route('login');
        }

        if (!auth()->user()->isAdmin()) {
            return redirect()->route('client.search');
        }
        dd(true);
        return $next($request);
    }
}
