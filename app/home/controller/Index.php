<?php
declare (strict_types=1);

namespace app\home\controller;

use app\BaseController;
use app\common\model\User;
use think\facade\View;


class Index extends BaseController
{
    public function index(): string
    {
        $result =User::where('user_account', 'q')->find();
        dump($result->toArray());
        View::assign('name', '111');
        return View::fetch();
    }


}
