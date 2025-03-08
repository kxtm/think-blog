<?php

namespace app\admin\controller;


use app\BaseController;
use think\facade\Request;
use think\facade\View;

class Article extends BaseController
{
    public function index(Request $request,$page=1): string
    {
        return View::fetch("index");
    }

    public function add(): string
    {
        return View::fetch("add");
    }

}