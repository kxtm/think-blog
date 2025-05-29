<?php

namespace app\home\controller;

use app\BaseController;
use think\facade\Request;
use think\facade\View;

class Category extends BaseController
{
    public function index()
    {

        return View::fetch();
    }

    public function articles(Request $request, $page = 1)
    {

        return 'detail' . '-' . $page;
    }

}