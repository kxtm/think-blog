<?php
// +----------------------------------------------------------------------
// | 应用设置
// +----------------------------------------------------------------------

return [

    'http_exception_template' => [
        400 => \think\facade\App::getAppPath() . '/view/error.html',
        401 => \think\facade\App::getAppPath() . '/view/error.html',
        403 => \think\facade\App::getAppPath() . '/view/error.html',
        404 => \think\facade\App::getAppPath() . '/view/error.html',
        500 => \think\facade\App::getAppPath() . '/view/error.html',
    ]
];
