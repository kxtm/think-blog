<?php

use think\facade\Route;

Route::group('/', function () {
    Route::get('', 'index/index');
});