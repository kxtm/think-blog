<?php

use think\facade\Route;

Route::group('/', function () {
    Route::get('', 'index/index');
    Route::post('login', 'index/login')->token();
});
Route::group('article', function () {
    Route::get('/', 'article/index');
    Route::get('/[:page]', 'article/index');
    Route::get('/[:title]/[:page]', 'article/index');
});