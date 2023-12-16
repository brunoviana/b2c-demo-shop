<?php

namespace BrunoViana\Zed\Tasks\Business;

use Generated\Shared\Transfer\TaskCollectionTransfer;
use Generated\Shared\Transfer\TaskCriteriaTransfer;
use Generated\Shared\Transfer\TaskResponseTransfer;
use Generated\Shared\Transfer\TaskTransfer;

interface TasksFacadeInterface
{
    public function createTask(TaskTransfer $taskTransfer): TaskResponseTransfer;

    public function updateTask(TaskTransfer $taskTransfer): TaskResponseTransfer;

    public function deleteTask(TaskTransfer $taskTransfer): TaskResponseTransfer;

    public function getTaskById(int $taskId): TaskResponseTransfer;

    public function getTaskCollection(TaskCriteriaTransfer $taskCriteriaTransfer): TaskCollectionTransfer;
}
