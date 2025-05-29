<?php

namespace app\common\model;

use think\Model;

class Task extends Model
{

    protected $pk = 'id'; // 主键

    // 设置字段信息
    protected $schema = [
        'id' => 'integer',
        'task_content' => 'string',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'create_time' => 'datetime',
        'update_time' => 'datetime',
    ];

    protected $mapping = [
        'id' => 'id',
        'task_content' => 'content',
        'start_time' => 'startTime',
        'end_time' => 'endTime',
        'create_time' => 'createTime',
        'update_time' => 'updateTime',
    ];

}