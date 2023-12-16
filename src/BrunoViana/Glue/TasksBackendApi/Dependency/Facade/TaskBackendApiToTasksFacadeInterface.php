<?php

namespace BrunoViana\Glue\TasksBackendApi\Dependency\Facade;

use BrunoViana\Zed\Tasks\Business\TasksFacadeInterface;
use Generated\Shared\Transfer\TaskResponseTransfer;
use Generated\Shared\Transfer\TaskTransfer;

interface TaskBackendApiToTasksFacadeInterface
{
    public function createTask(TaskTransfer $taskTransfer): TaskResponseTransfer;

    public function updateTask(TaskTransfer $taskTransfer): TaskResponseTransfer;

    public function deleteTask(TaskTransfer $taskTransfer): TaskResponseTransfer;

    public function getTaskById(int $taskId): TaskResponseTransfer;
}
