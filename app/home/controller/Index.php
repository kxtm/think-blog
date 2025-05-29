<?php
declare (strict_types=1);

namespace app\home\controller;

use app\BaseController;
use think\facade\View;


class Index extends BaseController
{
    public function index(): string
    {
        View::assign('name', '111');
        return View::fetch();
    }
}
