<?php
declare (strict_types=1);

namespace app\admin\controller;

use app\BaseController;
use app\common\captcha\Captcha;
use app\common\utils\Constr;
use app\common\validate\LoginValidate;
use app\Request;
use Exception;
use think\exception\ValidateException;
use think\facade\Log;
use think\facade\Session;
use think\facade\View;

class Index extends BaseController
{
    public function index()
    {
        View::assign(Constr::$error, Session::pull(Constr::$error));
        view::assign('username', Session::get('username'));
        return View::fetch();
    }

    /**
     * @throws Exception
     */
    public function verify()
    {
        $captcha = new Captcha();
        $code = $captcha->getCode();
        Log::info('生成验证码' . $code);
        Session::set(Constr::$captcha, $code);
        return $captcha->create($code);
    }

    public
    function login(Request $request)
    {
        Log::info('获取的' . Session::get(Constr::$captcha));
        Log::info('输入验证码' . $request->post('code'));
        try {
            validate(LoginValidate::class)->check($request->post());
        } catch (ValidateException $e) {
            Session::set(Constr::$error, $e->getMessage());
        }
        Session::set('username', $request->post('username'));
        if (Session::get(Constr::$captcha) != mb_strtolower($request->post('code'))) {
            // 验证失败
            Session::set(Constr::$error, '验证码错误');
        }
        if (!Session::has(Constr::$error)) {
            Session::delete(Constr::$captcha);
            Session::delete(Constr::$error);
            return redirect('/gl/main');
        }
        return redirect('/gl');
    }

    public
    function logout()
    {
        Session::clear();
        return redirect('/gl');
    }

    public
    function main()
    {
        dump(Session::get('captcha'));
        return View::fetch('main');
    }

}
