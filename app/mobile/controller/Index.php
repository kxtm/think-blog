<?php
declare (strict_types = 1);

namespace app\mobile\controller;

use app\BaseController;
use think\facade\View;

class Index extends BaseController
{
    public function index(): string
    {
        View::assign('title','您好！这是一个[mobile]示例应用');

        return View::fetch();
    }
}
