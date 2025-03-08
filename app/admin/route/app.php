<?php

use think\facade\Route;

Route::group('/', function () {
    Route::get('', 'index/index');
});
Route::group('article', function () {
    Route::get('', 'article/index');
});