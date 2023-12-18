<?php

namespace BrunoViana\Zed\Tasks\Business\Writer;

use Generated\Shared\Transfer\TaskErrorTransfer;
use Generated\Shared\Transfer\TaskResponseTransfer;
use Generated\Shared\Transfer\TaskTransfer;
use BrunoViana\Zed\Tasks\Persistence\TasksEntityManagerInterface;

class TaskWriter implements TaskWriterInterface
{
    public function __construct(
        protected TasksEntityManagerInterface $entityManager,
    ) {}

    public function createTask(TaskTransfer $taskTransfer): TaskResponseTransfer
    {
        $taskTransfer->requireTitle()->requireStatus();

        try{
            $taskTransfer = $this->entityManager->createTask($taskTransfer);

            return (new TaskResponseTransfer())->setTaskTransfer($taskTransfer)
                ->setIsSuccessful(true);
        } catch (\Exception $exception) {
            return (new TaskResponseTransfer())->setIsSuccessful(false)
                                                ->addError(
                                                    (new TaskErrorTransfer())->setMessage(
                                                        'An error occurred while creating the task'
                                                    )
                                                );
        }

    }

    public function updateTask(TaskTransfer $taskTransfer): TaskResponseTransfer
    {
        try{
            $taskTransfer = $this->entityManager->updateTask($taskTransfer);

            if (!$taskTransfer) {
                return (new TaskResponseTransfer())->setIsSuccessful(false)
                    ->addError(
                        (new TaskErrorTransfer())->setMessage(
                            'It\'s impossible to update this task.',
                        )
                    );
            }

            return (new TaskResponseTransfer())->setTaskTransfer($taskTransfer)
                ->setIsSuccessful(true);
        } catch (\Exception $exception) {
            return (new TaskResponseTransfer())->setIsSuccessful(false)
                ->addError(
                    (new TaskErrorTransfer())->setMessage(
                        'An error occurred while updating the task'
                    )
                );
        }
    }

    public function deleteTask(TaskTransfer $taskTransfer): TaskResponseTransfer
    {
        $this->entityManager->deleteTask($taskTransfer);

        return (new TaskResponseTransfer())->setIsSuccessful(true);
    }

}
