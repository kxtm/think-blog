<?php
declare (strict_types = 1);

namespace app\common\model;

use think\Model;

/**
 * @mixin Model
 */
class User extends Model
{
    //定义表明
   // protected $table = 't_user';
    protected $pk = 'id'; // 主键

    // 设置字段信息
    protected $schema = [
        'id' => 'integer',
        'user_account' => 'string',
        'user_passwd' => 'string',
        'user_name' => 'string',
        'user_sex' => 'integer',
        'user_email' => 'string',
        'user_phone' => 'string',
        'user_state' => 'integer',
        'user_token' => 'string',
        'create_time' => 'datetime',
        'update_time' => 'datetime',
    ];

    protected $mapping = [
        'id' => 'id',
        'user_account' => 'account',
        'user_passwd' => 'passwd',
        'user_name' => 'name',
        'user_sex' => 'sex',
        'user_email' => 'email',
        'user_phone' => 'phone',
        'user_state' => 'state',
        'user_token' => 'token',
        'create_time' => 'createTime',
        'update_time' => 'updateTime',
    ];



}
