<?php
namespace app\admin\controller;

use app\BaseController;

class Common extends BaseController
{

    protected function check_login(): bool
    {
      return true;
    }

}