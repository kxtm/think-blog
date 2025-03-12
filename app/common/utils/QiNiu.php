<?php

namespace app\common\utils;

use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

require_once 'vendor/autoload.php';

class QiNiu
{


    public static function upload($fileName, $filePath)
    {

        $accessKey = 'Access_Key';
        $secretKey = 'Secret_Key';
        $bucket = 'estatic';
        //初始化Auth状态
        $auth = new Auth($accessKey, $secretKey);

        // 生成上传 Token
        $token = $auth->uploadToken($bucket);
        // 要上传文件的本地路径
        $filePath = './php-logo.png';
        // 上传到存储后保存的文件名
        $key = 'my-php-logo.png';
        // 初始化 UploadManager 对象并进行文件的上传。
        $uploadMgr = new UploadManager();
        // 调用 UploadManager 的 putFile 方法进行文件的上传。
        list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath, null, 'application/octet-stream', true, null, 'v2');
        echo "\n====> putFile result: \n";
        if ($err !== null) {
            var_dump($err);
        } else {
            var_dump($ret);
        }

    }

}