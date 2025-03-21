<?php

namespace app\common\middleware;

class Policy
{
    public function handle($request, \Closure $next)
    {
        header("default-src \'self\' \'unsafe-inline\'  data:;");
        return $next($request);
    }
}