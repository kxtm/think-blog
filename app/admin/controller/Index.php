<?php
declare (strict_types=1);

namespace app\admin\controller;

use app\BaseController;
use app\common\captcha\Captcha;
use app\common\service\UserService;
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

    protected UserService $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


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

    public function login(Request $request)
    {
        try {
            $data = $request->post();
            Session::set('username', $data['username']);
            validate(LoginValidate::class)->check($data);
            if (!$this->validateCaptcha($data['code'])) {
                Session::set(Constr::$error, '验证码错误');
                return redirect('/gl');
            }
            $pwd = aesUtil::dec($data['password'], Session::pull('key'), Session::pull('iv'));
            Log::info('解密后的密码: ' . $pwd);
            $loginToken = $this->userService->login($data['username'], $pwd);
            if (is_null($loginToken)) {
                Session::set(Constr::$error, '用户名或密码错误');
                return redirect('/gl');
            }
            Session::set(Constr::$utk, $loginToken);
            return redirect(url('/gl/main')->build());
        } catch (ValidateException $e) {
            Session::set(Constr::$error, $e->getMessage());
            return redirect('/gl');
        } catch (\Exception $e) {
            Log::error('登录异常: ' . $e->getMessage());
            Session::set(Constr::$error, '登录失败，请稍后重试', 300);
            return redirect('/gl');
        }
    }

    public function logout()
    {
        Session::clear();
        return redirect('/gl');
    }

    public function main()
    {
        return View::fetch('main');
    }

    protected function validateCaptcha($inputCode)
    {
        $captcha = strtolower(Session::pull(Constr::$captcha));
        $inputCode = strtolower($inputCode);
        Log::info('验证码错误 -> 输入: ' . $inputCode . ' -> 预期: ' . $captcha);
        return $inputCode === $captcha;
    }

}
