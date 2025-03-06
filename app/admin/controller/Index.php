<?php
declare (strict_types=1);

namespace app\admin\controller;

use app\common\validate\User;
use think\exception\ValidateException;
use think\facade\View;
use think\response\Redirect;

class Index extends Common
{
    public function index(): string
    {

        View::assign('msg', '您好！这是一个[admin]示例应用');

        return View::fetch();
    }

    public function login(): Redirect
    {
        try {
            validate(User::class)->check($this->request->post());
        } catch (ValidateException $e) {
            // 验证失败
            dump($e->getError()); // 输出错误信息
            dump($e->getKey()); // 验证错误的字段名
        }
        return redirect('/admin/dabrod');
    }
}
