<?php
declare (strict_types=1);

namespace app\common\service;


use app\common\model\User;
use Ramsey\Uuid\Uuid;
use think\app\Service;

class UserService extends Service
{
    /**
     * @param string $username 扽了
     * @param string $password
     * @return string|null
     */
    public function login(string $username, string $password)
    {
        $user = User::where('user_account', $username)->findOrEmpty();
        if (!$user->isEmpty() && $user->passwd == md5($password) && $user->account == $username) {
            $uid = str_replace('-', '', Uuid::uuid4()->toString());
            User::where('user_account', $username)->update(['user_token' => $uid, 'update_time' => date('Y-m-d H:i:s')]);
            return $uid;
        }
        return null;
    }

    public function getUser(string $token)
    {

    }

}
