<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Class Cors
 * @package App\Http\Middleware
 */
class Cors
{
    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Options', 'GET, POST, PUT, PATCH, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Authorization, Api-Token, Content-type, X-Requested-With')
            ->header('Access-Control-Expose-Headers', 'Authorization, Api-Token');
    }
}
