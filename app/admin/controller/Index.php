<?php
declare (strict_types=1);

namespace app\admin\controller;

use app\BaseController;
use app\common\validate\LoginValidate;
use app\Request;
use think\exception\ValidateException;
use think\facade\Session;
use think\facade\View;

class Index extends BaseController
{
    public function index(Request $request)
    {

        View::assign('error', Session::pull('error'));
        view::assign('username', Session::pull('username'));
        return View::fetch();
    }

    public function login(Request $request)
    {
        try {
            validate(LoginValidate::class)->check($request->post());
        } catch (ValidateException $e) {
            Session::set('error', $e->getMessage());
        }
        Session::set('username', $request->post('username'));
        if (!captcha_check($request->post('captcha'))) {
            // 验证失败
            Session::set('error', '验证码错误');
        }
        if (!Session::has('error')) {
            return View::fetch('main');
        }
        return redirect('/gl');
    }
}
