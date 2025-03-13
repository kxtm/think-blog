<?php

namespace app\common\utils;

class Result
{
    public static function ok(string $msg = "",mixed $data=null)
    {
        return json(['success' => true, 'msg' => $msg, 'data' => $data]);
    }

    public static function error(string $msg = "")
    {
        return json(['success' => false, 'msg' => $msg]);
    }
}