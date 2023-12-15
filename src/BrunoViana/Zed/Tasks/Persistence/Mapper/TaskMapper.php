<?php

namespace BrunoViana\Zed\Tasks\Persistence\Mapper;

use Generated\Shared\Transfer\TaskTransfer;
use Orm\Zed\Tasks\Persistence\BvTask;

class TaskMapper
{
    public function mapTaskTransferToTaskEntity(TaskTransfer $taskTransfer, BvTask $BvTask): BvTask
    {
        return $BvTask->fromArray($taskTransfer->toArray());
    }

    public function mapTaskEntityToTaskTransfer(BvTask $BvTask, TaskTransfer $taskTransfer): TaskTransfer
    {
        return $taskTransfer->fromArray($BvTask->toArray(), true);
    }
}
