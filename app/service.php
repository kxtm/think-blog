<?php

use app\AppService;
use app\common\service\TaskSevice;
use app\common\service\UserService;

// 系统服务定义文件
// 服务在完成全局初始化之后执行
return [
    AppService::class,
    UserService::class,
    TaskSevice::class,
];
