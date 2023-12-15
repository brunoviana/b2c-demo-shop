<?php

namespace BrunoViana\Zed\Tasks\Persistence\Mapper;

use Generated\Shared\Transfer\TaskTransfer;
use Orm\Zed\Tasks\Persistence\BrunovianaTask;

class TaskMapper
{
    public function mapTaskTransferToTaskEntity(TaskTransfer $taskTransfer, BrunovianaTask $BrunovianaTask): BrunovianaTask
    {
        return $BrunovianaTask->fromArray($taskTransfer->toArray());
    }

    public function mapTaskEntityToTaskTransfer(BrunovianaTask $BrunovianaTask, TaskTransfer $taskTransfer): TaskTransfer
    {
        return $taskTransfer->fromArray($BrunovianaTask->toArray(), true);
    }
}
