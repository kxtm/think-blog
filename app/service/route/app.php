<?php

use think\facade\Route;

Route::group('task', function () {
    Route::get('', 'Task/index');
    Route::post('add', 'Task/addTask');
})->allowCrossDomain();

Route::miss(function () {
   return json(['success'=>false,'msg'=>'系统错误']);
});