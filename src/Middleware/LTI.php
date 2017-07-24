<?php

namespace RobertBoes\LaravelLti\Middleware;

use Closure;

class LTI
{
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}