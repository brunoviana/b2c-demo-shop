<?php

namespace BrunoViana\Zed\Tasks\Business\Reader;

use Generated\Shared\Transfer\TaskResponseTransfer;

interface TaskReaderInterface
{
    public function getTaskById(int $taskId): TaskResponseTransfer;
}
