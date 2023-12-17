<?php

namespace BrunoViana\Zed\Tasks\Persistence;

use Generated\Shared\Transfer\StoreTransfer;
use Generated\Shared\Transfer\TaskTransfer;
use Orm\Zed\Tasks\Persistence\BvTask;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \BrunoViana\Zed\Tasks\Persistence\TasksPersistenceFactory getFactory()
 */
class TasksEntityManager extends AbstractEntityManager implements TasksEntityManagerInterface
{
    public function createTask(TaskTransfer $taskTransfer): TaskTransfer
    {
        $taskTransfer->requireTitle()
            ->requireStatus()
            ->requireDueAt()
            ->requireIdAssignee();

        $taskMapper = $this->getFactory()->createTaskMapper();

        $taskEntity = $taskMapper->mapTaskTransferToTaskEntity(
            $taskTransfer,
            new BvTask()
        );

        $taskEntity->save();

        return $taskMapper->mapTaskEntityToTaskTransfer($taskEntity, new TaskTransfer());
    }

    public function updateTask(TaskTransfer $taskTransfer): ?TaskTransfer
    {
        $taskTransfer->requireIdTask();

        $taskEntity = $this->getFactory()
            ->createTaskQuery()
            ->filterByIdTask($taskTransfer->getIdTask())
            ->findOne();

        if (!$taskEntity) {
            return null;
        }

        $taskMapper = $this->getFactory()->createTaskMapper();

        $taskEntity = $taskMapper->mapTaskTransferToTaskEntity(
            $taskTransfer,
            $taskEntity
        );

        $taskEntity->save();

        return $taskMapper->mapTaskEntityToTaskTransfer($taskEntity, new TaskTransfer());
    }

    public function deleteTask(TaskTransfer $taskTransfer): void
    {
        $taskTransfer->requireIdTask();

        $this->getFactory()
            ->createTaskQuery()
            ->filterByIdTask($taskTransfer->getIdTask())
            ->delete();
    }
}
