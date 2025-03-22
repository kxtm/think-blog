<?php

use think\facade\Route;

Route::group('/', function () {
    Route::get('', 'index/index');
    Route::get('search', 'search/index');
});


Route::miss(function () {
    return \think\facade\View::fetch('error');
});