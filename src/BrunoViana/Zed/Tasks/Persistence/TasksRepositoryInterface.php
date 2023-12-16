<?php

namespace BrunoViana\Zed\Tasks\Persistence;

use Generated\Shared\Transfer\TaskCollectionTransfer;
use Generated\Shared\Transfer\TaskCriteriaTransfer;
use Generated\Shared\Transfer\TaskTransfer;

interface TasksRepositoryInterface
{
    public function getTaskById(int $taskId): ?TaskTransfer;

    public function getTaskCollection(
        TaskCriteriaTransfer $taskCriteriaTransfer
    ): TaskCollectionTransfer;
}
