<?php

namespace BrunoVianaTest\Zed\Tasks\Helper;

use Codeception\Module;
use Generated\Shared\DataBuilder\TaskBuilder;
use Generated\Shared\Transfer\TaskTransfer;
use Generated\Shared\Transfer\UserTransfer;
use BrunoViana\Zed\Tasks\Business\TasksFacadeInterface;
use SprykerTest\Shared\Testify\Helper\DataCleanupHelperTrait;
use SprykerTest\Shared\Testify\Helper\LocatorHelperTrait;

class TaskDataHelper extends Module
{
    use LocatorHelperTrait;
    use DataCleanupHelperTrait;

    /**
     * @param string[] $override
     * @return TaskTransfer
     */
    public function haveTask(array $override = []): TaskTransfer
    {
        $taskTransfer = (new TaskBuilder($override))->build();
        $taskTransfer = ($this->getTaskFacade()->createTask($taskTransfer))->getTaskTransfer();

        $this->getDataCleanupHelper()->_addCleanup(function () use ($taskTransfer): void {
            $this->cleanupTask($taskTransfer);
        });

        return $taskTransfer;
    }

    private function getTaskFacade(): TasksFacadeInterface
    {
        return $this->getLocatorHelper()->getLocator()->tasks()->facade();
    }

    protected function cleanupTask(TaskTransfer $taskTransfer): void
    {
        $this->getTaskFacade()->deleteTask($taskTransfer);
    }
}
