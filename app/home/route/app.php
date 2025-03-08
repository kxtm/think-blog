<?php

use think\facade\Route;

Route::group('/', function () {
    Route::get('', 'index/index');
    Route::get('search', 'search/index');
});