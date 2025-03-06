<?php
namespace app\gl\controller;

use app\BaseController;

class Common extends BaseController
{

    protected function check_login(): bool
    {
      return true;
    }

}