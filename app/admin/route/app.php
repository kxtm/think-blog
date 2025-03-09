<?php

use app\common\middleware\Auth;
use think\facade\Route;

Route::group('/', function () {
    Route::get('', 'index/index');
    Route::get('verify', 'index/verify');
    Route::post('login', 'index/login')->token();
    Route::post('logout', 'index/logout')->middleware(Auth::class);
    Route::get('main', 'index/main');
})->name('gl');
Route::group('article', function () {
    Route::get('/', 'article/index');
    Route::get('/[:page]', 'article/index');
    Route::get('/[:title]/[:page]', 'article/index');
})->middleware(Auth::class);