<?php
declare (strict_types=1);

namespace app\admin\controller;

use app\BaseController;
use app\common\captcha\Captcha;
use app\common\model\User;
use app\common\utils\AesUtil;
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
    /**
     * @throws Exception
     */
    public function index()
    {
        Session::set('key', AesUtil::getKV());
        Session::set('iv', AesUtil::getKV());
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
        $pwd = AesUtil::dec($request->post('password'), Session::pull('key'), Session::pull('iv'));
        Log::info($pwd);
        if (!Session::has(Constr::$error)) {
            Session::delete(Constr::$captcha);
            Session::delete(Constr::$error);
            Session::set(Constr::$utk, new User());
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
        return View::fetch('main');
    }

}
