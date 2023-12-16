<?php

namespace BrunoViana\Glue\TasksBackendApi\Dependency\Facade;

use BrunoViana\Zed\Tasks\Business\TasksFacadeInterface;
use Generated\Shared\Transfer\TaskResponseTransfer;
use Generated\Shared\Transfer\TaskTransfer;

class TaskBackendApiToTasksFacade implements TaskBackendApiToTasksFacadeInterface
{
    public function __construct(
        protected TasksFacadeInterface $tasksFacade,
    ) {}

    public function createTask(TaskTransfer $taskTransfer): TaskResponseTransfer
    {
        return $this->tasksFacade->createTask($taskTransfer);
    }

    public function updateTask(TaskTransfer $taskTransfer): TaskResponseTransfer
    {
        return $this->tasksFacade->updateTask($taskTransfer);
    }

    public function deleteTask(TaskTransfer $taskTransfer): TaskResponseTransfer
    {
        return $this->tasksFacade->deleteTask($taskTransfer);
    }

    public function getTaskById(int $taskId): TaskResponseTransfer
    {
        return $this->tasksFacade->getTaskById($taskId);
    }

}
