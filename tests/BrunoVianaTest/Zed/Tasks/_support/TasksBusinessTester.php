<?php

declare(strict_types=1);

namespace BrunoVianaTest\Zed\Tasks;

use Codeception\Stub;
use Exception;
use Generated\Shared\DataBuilder\TaskBuilder;
use Generated\Shared\Transfer\TaskCollectionTransfer;
use Generated\Shared\Transfer\TaskResponseTransfer;
use Generated\Shared\Transfer\TaskTransfer;
use BrunoViana\Zed\Tasks\Persistence\TasksEntityManagerInterface;

/**
 * Inherited Methods
 * @method void wantTo($text)
 * @method void wantToTest($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause($vars = [])
 *
 * @method \BrunoViana\Zed\Tasks\Business\TasksFacadeInterface getFacade()
 *
 * @SuppressWarnings(PHPMD)
*/
class TasksBusinessTester extends \Codeception\Actor
{
    use _generated\TasksBusinessTesterActions;

    /**
     * @param array<int, mixed> $seedData
     * @return TaskTransfer
     */
    public function getTaskTransfer(array $seedData = []): TaskTransfer
    {
        return (new TaskBuilder($seedData))->build();
    }

    public function getTaskTransferWithUser(array $seedData = []): TaskTransfer
    {
        return $this->getTaskTransfer([
            TaskTransfer::ID_ASSIGNEE => $this->haveUser()->getIdUser(),
            ...$seedData
        ]);
    }

    public function haveTaskWithUser(array $seedData = []): TaskTransfer
    {
        return $this->haveTask([
            TaskTransfer::ID_ASSIGNEE => $this->haveUser()->getIdUser(),
            ...$seedData
        ]);
    }

    /**
     * @throws Exception
     */
    public function mockEntityManagerCreateTaskWithException(): void
    {
        $taxAppEntityManagerMock = Stub::makeEmpty(TasksEntityManagerInterface::class, [
            'createTask' => function (): void {
                throw new Exception('something went wrong');
            },
        ]);

        $this->mockFactoryMethod('getEntityManager', $taxAppEntityManagerMock);
    }

    /**
     * @throws Exception
     */
    public function mockEntityManagerUpdateTaskWithException(): void
    {
        $taxAppEntityManagerMock = Stub::makeEmpty(TasksEntityManagerInterface::class, [
            'updateTask' => function (): void {
                throw new Exception('something went wrong');
            },
        ]);

        $this->mockFactoryMethod('getEntityManager', $taxAppEntityManagerMock);
    }

    public function assertActualTaskIsSameAsExpectedTask(
        TaskTransfer $expectedTask,
        TaskTransfer $actualTask,
    ): void {
        $this->assertSame(
            $expectedTask->getTitle(),
            $actualTask->getTitle(),
            'Actual task must have the same title as expected task'
        );

        $this->assertSame(
            $expectedTask->getDescription(),
            $actualTask->getDescription(),
            'Actual task must have the same description as expected task'
        );

        $this->assertSame(
            $expectedTask->getStatus(),
            $actualTask->getStatus(),
            'Actual task must have the same status as expected task'
        );

        $this->assertEquals(
            new \DateTime($expectedTask->getDueAt()),
            new \DateTime($actualTask->getDueAt()),
            'Actual task must have the same due date as expected task'
        );

        $this->assertSame(
            $expectedTask->getIdAssignee(),
            $actualTask->getIdAssignee(),
            'Actual task must have the same assignee id as expected task'
        );
    }

    public function assertTasksFacadeCreateTaskResponseHasRightDataForSuccessfullRequest(
        TaskResponseTransfer $taskResponseTransfer,
    ): void {
        $this->assertNotNull(
            $taskResponseTransfer->getTaskTransfer()->getIdTask(),
            'Task id cannot be null',
        );

        $this->assertTrue(
            $taskResponseTransfer->getIsSuccessful(),
            'Response must return successful flag as true',
        );
    }

    public function assertTaskResponseReturnedError(
        TaskResponseTransfer $taskResponseTransfer,
        string $expectedErrorMessage,
    ): void {
        $this->assertNull(
            $taskResponseTransfer->getTaskTransfer(),
            'Task response must return no task transfer',
        );

        $this->assertFalse(
            $taskResponseTransfer->getIsSuccessful(),
            'Response must return successful flag as false',
        );

        $this->assertEquals(
            $taskResponseTransfer->getErrors()[0]->getMessage(),
            $expectedErrorMessage,
        );
    }

    public function assertTasksFacadeUpdateTaskResponseHasRightDataForSuccessfullRequest(
        TaskResponseTransfer $taskResponseTransfer,
        TaskTransfer $originalTaskTransfer,
    ): void {
        $updatedTaskTransfer = $taskResponseTransfer->getTaskTransfer();

        $this->assertTrue(
            $taskResponseTransfer->getIsSuccessful(),
            'Response must return successful flag as true',
        );

        $this->assertEquals(
            $originalTaskTransfer->getIdTask(),
            $updatedTaskTransfer->getIdTask(),
            'Updated task must have the same id as original task',
        );
    }

    public function assertTasksFacadeDeleteTaskResponseHasRightDataForSuccessfullRequest(
        TaskResponseTransfer $taskResponseTransfer,
        TaskTransfer $originalTaskTransfer,
    ): void {
        $this->assertTrue(
            $taskResponseTransfer->getIsSuccessful(),
            'Response must return successful flag as true',
        );

        $this->assertNull(
            $taskResponseTransfer->getTaskTransfer(),
            'Response must return no task transfer',
        );

        $this->assertEquals(
            0,
            $taskResponseTransfer->getErrors()->count(),
            'Response must return no errors',
        );
    }

    public function assertTaskDontExistInStorage(TaskTransfer $originalTaskTransfer)
    {
        $taskResponseTransfer = $this->getFacade()->getTaskById(
            $originalTaskTransfer->getIdTask()
        );

        $this->assertNull(
            $taskResponseTransfer->getTaskTransfer(),
            'Task must not exist in storage anymore',
        );

        $this->assertFalse(
            $taskResponseTransfer->getIsSuccessful(),
            'get task response must return successful flag as false after deleting',
        );
    }

    public function assertTasksFacadeGetTaskByIdResponseHasRightDataForSuccessfullRequest(
        TaskResponseTransfer $taskResponseTransfer,
    ): void {
        $this->assertNotNull(
            $taskResponseTransfer->getTaskTransfer()->getIdTask(),
            'Task id cannot be null',
        );

        $this->assertTrue(
            $taskResponseTransfer->getIsSuccessful(),
            'Response must return successful flag as true',
        );
    }

    public function assertGetTaskCollectionResponseReturnedJustOneTask(
        TaskCollectionTransfer $taskCollectionTransfer,
    ): void {
        $this->assertCount(1, $taskCollectionTransfer->getTasks());
    }
}
