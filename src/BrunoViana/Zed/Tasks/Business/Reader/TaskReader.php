<?php

namespace BrunoViana\Zed\Tasks\Business\Reader;

use BrunoViana\Zed\Tasks\Persistence\TasksRepositoryInterface;
use Generated\Shared\Transfer\TaskErrorTransfer;
use Generated\Shared\Transfer\TaskResponseTransfer;

class TaskReader implements TaskReaderInterface
{
    public function __construct(
        protected TasksRepositoryInterface $taskRepository,
    ) {}

    public function getTaskById(int $taskId): TaskResponseTransfer
    {
        $taskTransfer = $this->taskRepository->getTaskById($taskId);

        if (!$taskTransfer) {
            return (new TaskResponseTransfer())
                ->setIsSuccessful(false)
                ->addError(
                    (new TaskErrorTransfer())->setMessage(
                        'Task not found.',
                    )
                );
        }

        return (new TaskResponseTransfer())->setTaskTransfer($taskTransfer)
            ->setIsSuccessful(true);
    }
}
