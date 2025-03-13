<?php

namespace app\common\service;

use app\common\model\Task;
use think\app\Service;
use think\facade\Db;

class TaskSevice extends Service
{

    public function save(array $taskData)
    {
        $task = new Task();
        return $task->save(['task_content' => $taskData['content'], 'start_time' => $taskData['startTime'], 'end_time' => $taskData['endTime'], 'create_time' => date('Y-m-d H:i:s'), 'update_time' => null]);
    }


    public function getTaskData(): array
    {
        $todyTotal = Db::query("SELECT SUM(TIMESTAMPDIFF(HOUR,start_time,end_time)) todyTotal FROM t_task where  DATE(create_time) = CURDATE()", []);
        $weekTotal = Db::query("SELECT SUM(TIMESTAMPDIFF(HOUR,start_time,end_time)) weekTotal  FROM t_task WHERE YEARWEEK(create_time) = YEARWEEK(CURDATE())", []);
        $monthTotal = Db::query("SELECT SUM(TIMESTAMPDIFF(HOUR,start_time,end_time))  monthTotal  FROM t_task WHERE MONTH(create_time) = MONTH(CURDATE()) AND YEAR(create_time) = YEAR(CURRENT_DATE())", []);
        $total = Db::query("SELECT COUNT(*) totalCount  from t_task", []);
        return [$todyTotal[0], $weekTotal[0], $monthTotal[0], $total[0]];
    }
}