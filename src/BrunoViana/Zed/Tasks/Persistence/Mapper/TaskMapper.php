<?php

namespace BrunoViana\Zed\Tasks\Persistence\Mapper;

use Generated\Shared\Transfer\TaskCollectionTransfer;
use Generated\Shared\Transfer\TaskTransfer;
use Orm\Zed\Tasks\Persistence\BvTask;
use Propel\Runtime\Collection\ObjectCollection;

class TaskMapper implements TaskMapperInterface
{
    public function mapTaskTransferToTaskEntity(TaskTransfer $taskTransfer, BvTask $BvTask): BvTask
    {
        return $BvTask->fromArray($taskTransfer->toArray());
    }

    public function mapTaskEntityToTaskTransfer(BvTask $BvTask, TaskTransfer $taskTransfer): TaskTransfer
    {
        return $taskTransfer->fromArray($BvTask->toArray(), true);
    }

    public function mapTaskQueryResultToTaskCollectionTransfer(
        ObjectCollection $taskQueryResult,
        TaskCollectionTransfer $taskCollectionTransfer,
    ): TaskCollectionTransfer {
        foreach ($taskQueryResult as $taskEntity) {
            $taskTransfer = $this->mapTaskEntityToTaskTransfer(
                $taskEntity,
                new TaskTransfer(),
            );

            $taskCollectionTransfer->addTask($taskTransfer);
        }

        return $taskCollectionTransfer;
    }
}
