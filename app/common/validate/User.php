<?php

namespace app\common\validate;

use think\Validate;

class User extends Validate
{
    protected $rule = [
        'username' => 'require|min:4',
        'password' => 'require|min:6',
    ];

    protected $message = [
        'username.require' => '用户名不能为空',
        'username.min'     => '用户名至少4个字符',
        'password.require' => '密码不能为空',
        'password.min'     => '密码长度至少6位',
    ];
}