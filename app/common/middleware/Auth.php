<?php
declare (strict_types=1);

namespace app\common\middleware;

use app\common\utils\Constr;
use think\facade\Log;
use think\facade\Session;
use think\Request;
use think\response\Redirect;


class Auth
{
    /**
     * 处理请求
     *
     * @param Request $request
     * @param \Closure $next
     * @return Redirect
     */
    public function handle(Request $request, \Closure $next)
    {
        Log::info($request->url());
        if (!Session::has(Constr::$utk)) {
            return redirect('/gl');
        }
        return $next($request);
    }
}
