<?php

namespace BrunoViana\Zed\Tasks\Business;

use Generated\Shared\Transfer\TaskResponseTransfer;
use Generated\Shared\Transfer\TaskTransfer;
use BrunoViana\Zed\Tasks\Business\TasksFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \BrunoViana\Zed\Tasks\Business\TasksBusinessFactory getFactory()
 * @method \BrunoViana\Zed\Tasks\Persistence\TasksRepositoryInterface getRepository()
 * @method \BrunoViana\Zed\Tasks\Persistence\TasksEntityManagerInterface getEntityManager()
 */
class TasksFacade extends AbstractFacade implements TasksFacadeInterface
{

    public function createTask(TaskTransfer $taskTransfer): TaskResponseTransfer
    {
        return $this->getFactory()->createTaskWriter()->createTask($taskTransfer);
    }

    public function updateTask(TaskTransfer $taskTransfer): TaskResponseTransfer
    {
        return $this->getFactory()->createTaskWriter()->updateTask($taskTransfer);
    }

    public function deleteTask(TaskTransfer $taskTransfer): TaskResponseTransfer
    {
        return $this->getFactory()->createTaskWriter()->deleteTask($taskTransfer);
    }

    public function getTaskById(int $taskId): TaskResponseTransfer
    {
        return $this->getFactory()->createTaskReader()->getTaskById($taskId);
    }
}
