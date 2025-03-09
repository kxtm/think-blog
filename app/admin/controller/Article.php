<?php

namespace app\admin\controller;


use app\BaseController;
use think\facade\View;

class Article extends BaseController
{
    public function index($title = null, $page = 1): string
    {
        View::assign('title', $title);
        View::assign('page', $page);
        return View::fetch("index");
    }

    public function add(): string
    {
        return View::fetch("add");
    }

}