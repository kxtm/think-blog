<?php

namespace app\common\validate;

use think\Validate;

class TaskValidate extends Validate
{
    protected $rule = [
        'content|内容' => 'require|chsAlphaNum',
        'startTime|开始时间' => 'require',
        'endTime|结束时间' => 'require'
    ];

    protected $message = [
        'username.require' => '内容不能为空',
        'startTime.require' => '任务开始时间不能为空',
        'endTime.require' => '任务结束时间不能为空',
    ];
}