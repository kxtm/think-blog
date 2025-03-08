<?php
declare (strict_types=1);

namespace app\admin\controller;

use app\BaseController;
use app\common\validate\LoginValidate;
use app\Request;
use think\exception\ValidateException;
use think\facade\View;

class Index extends BaseController
{
    public function index()
    {
        dump(session('error'));
        return View::fetch();
    }

    public function login(Request $request)
    {
        dump($request->post());
        try {
            validate(LoginValidate::class)->check($request->post());
        } catch (ValidateException $e) {
            session('error', $e->getMessage());
            dump(session('error'));
        }
        return view::fetch('main');
    }
}
