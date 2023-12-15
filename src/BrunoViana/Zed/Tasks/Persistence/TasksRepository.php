<?php

namespace BrunoViana\Zed\Tasks\Persistence;

use Generated\Shared\Transfer\TaskTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \BrunoViana\Zed\Tasks\Persistence\TasksPersistenceFactory getFactory()
 */
class TasksRepository extends AbstractRepository implements TasksRepositoryInterface
{
    public function getTaskById(int $taskId): ?TaskTransfer
    {
        $taskEntity = $this->getFactory()
            ->createTaskQuery()
            ->filterByIdTask($taskId)
            ->findOne();

        if (!$taskEntity) {
            return null;
        }

        return $this->getFactory()
            ->createTaskMapper()
            ->mapTaskEntityToTaskTransfer($taskEntity, new TaskTransfer());
    }
}
