<?php
declare (strict_types=1);

namespace app\home\controller;

use think\facade\View;


class Index
{
    public function index(): string
    {
        View::assign('name', '您好！这是一个[home]示例应用1111');
        return View::fetch();
    }


}
