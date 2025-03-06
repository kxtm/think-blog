<?php
declare (strict_types=1);

namespace app\home\controller;

use app\BaseController;
use app\common\model\UserModel;
use think\facade\View;


class Index extends BaseController
{
    public function index(): string
    {
        $user =UserModel::where('user_account', 'q')->find();
        dump($user->toArray());
        View::assign('name', '111');
        return View::fetch();
    }


}
