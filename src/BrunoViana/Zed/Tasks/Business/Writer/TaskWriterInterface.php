<?php

namespace BrunoViana\Zed\Tasks\Business\Writer;

use Generated\Shared\Transfer\TaskResponseTransfer;
use Generated\Shared\Transfer\TaskTransfer;

interface TaskWriterInterface
{
    public function createTask(TaskTransfer $taskTransfer): TaskResponseTransfer;

    public function updateTask(TaskTransfer $taskTransfer): TaskResponseTransfer;

    public function deleteTask(TaskTransfer $taskTransfer): TaskResponseTransfer;
}
