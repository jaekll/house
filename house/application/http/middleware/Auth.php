<?php

namespace app\http\middleware;

use think\exception\HttpException;
use think\Request;

class Auth
{
    public function handle(Request $request, \Closure $next)
    {
        if ($request->param('token')!== 'acd1231aa' ){
            throw new HttpException('403','没有权限');
        }

        return $next($request);
    }
}
