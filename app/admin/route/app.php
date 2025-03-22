<?php

use app\common\middleware\Auth;
use think\facade\Route;

Route::group('/', function () {
    Route::get('', 'index/index');
    Route::get('verify', 'index/verify');
    Route::post('login', 'index/login')->token();
    Route::get('logout', 'index/logout')->middleware(Auth::class);
    Route::get('main', 'index/main')->middleware(Auth::class);
})->name('gl');
Route::group('article', function () {
    Route::get('/', 'article/index');
    Route::get('add', 'article/add');
    Route::get('/[:page]', 'article/index');
    Route::get('/[:title]/[:page]', 'article/index');
})->middleware(Auth::class);

Route::group('category', function () {
    Route::get('/', 'category/index');

})->middleware(Auth::class);
Route::group('tag', function () {
    Route::get('/', 'tag/index');

})->middleware(Auth::class);

Route::group('site', function () {
    Route::get('/', 'site/index');

})->middleware(Auth::class);
Route::group('album', function () {
    Route::get('/', 'album/index');

})->middleware(Auth::class);
Route::group('attachment', function () {
    Route::get('/', 'attachment/index');

})->middleware(Auth::class);



Route::miss(function () {
    return \think\facade\View::fetch('error');
});