<?php

namespace BrunoViana\Zed\Tasks\Persistence;

use Generated\Shared\Transfer\TaskTransfer;

interface TasksRepositoryInterface
{
    public function getTaskById(int $taskId): ?TaskTransfer;
}
