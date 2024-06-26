<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Session;

class MasterAdminCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ((Session::get('userdata')->username === 'SuperAdminOlivia') || (Session::get('userdata')->username === 'superuser')) {
            return $next($request);
        } else {
            return abort('403');
        }

    }
}
