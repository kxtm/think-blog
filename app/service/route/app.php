<?php

use think\facade\Route;

Route::group('task', function () {
    Route::get('', 'Task/index');
    Route::post('add', 'Task/addTask');
})->allowCrossDomain();