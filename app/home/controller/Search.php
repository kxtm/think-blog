<?php
declare (strict_types = 1);

namespace app\home\controller;

use app\BaseController;
use think\facade\View;
use think\Request;

class Search extends BaseController
{
    /**
     * 显示资源列表
     *
     * @return string
     */
    public function index(Request $request): string
    {
        //
        $keyword = $request->param('keyword');
        View::assign('keyword', $keyword);
        return View::fetch();
    }
}
