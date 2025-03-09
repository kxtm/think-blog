<?php

namespace app\common\utils;

use Exception;

class AesUtil
{


    public static function dec($str, $key, $iv)
    {
        return openssl_decrypt(base64_decode($str), 'aes-128-cbc', $key, OPENSSL_RAW_DATA, $iv);
    }

    public static function enc($str, $key, $iv)
    {
        return base64_encode(openssl_encrypt($str, 'aes-128-cbc', $key, OPENSSL_RAW_DATA, $iv));
    }


    /**
     * @throws Exception
     */
    public static function getKV()
    {
        $bag = '';
        $str = "1234567890qazwsxedcrfvtgbyhnujmikolpQAZWSXEDCRFVTGBYHNUJMIKLOP";
        $seed = str_split($str);
        for ($i = 0; $i < 16; $i++) {
            $bag .= $seed[random_int(0, count($seed) - 1)];
        }
        return $bag;
    }

}