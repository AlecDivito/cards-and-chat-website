<?php

namespace App\Http\Middleware;

use Closure;

class getIPAddress
{
    /**
     * Append the attribute 'ip' to the request class
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request['ip'] = \Request::ip();
        return $next($request);
    }
}
