<?php

namespace app\common\validate;

use think\Validate;

class LoginValidate extends Validate
{
    protected $rule = [
        'username|用户名' => 'require|alphaNum',
        'password|密码' => 'require|min:6',
        'captcha|验证码' => 'require|captcha'
    ];

    protected $message = [
        'username.require' => '用户名不能为空',
        'password.require' => '密码不能为空',
        'password.min' => '密码长度至少6位',
    ];
}