<?php

namespace app\gl\controller;



use think\facade\View;

class Article extends Common
{
    public function index(): string
    {
        return View::fetch("index");
    }

    public function add(): string
    {
        return View::fetch("add");
    }

}