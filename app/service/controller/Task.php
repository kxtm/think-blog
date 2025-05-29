<?php

namespace app\service\controller;

use app\BaseController;
use app\common\service\TaskSevice;
use app\common\utils\Result;
use app\common\validate\TaskValidate;
use app\Request;

class Task extends BaseController
{
    protected TaskSevice $taskService;

    public function __construct(TaskSevice $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index()
    {
        $data=$this->taskService->getTaskData();
        return Result::ok('',$data);
    }

    public function addTask(Request $request)
    {
        try {
            $data = $request->post();
            validate(TaskValidate::class)->check($data);
            if ($this->taskService->save($data)) return Result::ok();
            return Result::ok();
        } catch (\Exception $e) {
            return Result::error($e->getMessage());
        }
    }

}