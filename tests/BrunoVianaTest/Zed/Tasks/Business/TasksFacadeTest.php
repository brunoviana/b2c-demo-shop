<?php

namespace BrunoVianaTest\Zed\Tasks\Business;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\PaginationTransfer;
use Generated\Shared\Transfer\SortTransfer;
use Generated\Shared\Transfer\TaskConditionsTransfer;
use Generated\Shared\Transfer\TaskCriteriaTransfer;
use Generated\Shared\Transfer\TaskTransfer;
use BrunoVianaTest\Zed\Tasks\TasksBusinessTester;
use Spryker\Shared\Kernel\Transfer\Exception\RequiredTransferPropertyException;

class TasksFacadeTest extends Unit
{

    protected TasksBusinessTester $tester;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tester->ensureTasksTableIsEmpty();
    }

    public function testCreateTaskIsExecutedSuccessfully(): void
    {
        // Arrange
        $taskTransfer = $this->tester->getTaskTransfer();

        // Act
        $createTaskResponse = $this->tester->getFacade()->createTask($taskTransfer);

        // Assert
        $this->tester->assertCreateTaskResponseIsCorrect($createTaskResponse);
    }

    public function testCreateTaskMustHandleUnexpectedExceptionSuccessfully(): void
    {
        // Arrange
        $taskTransfer = $this->tester->getTaskTransfer();

        $this->tester->mockEntityManagerCreateTaskWithException();

        // Act
        $createTaskResponse = $this->tester->getFacade()->createTask($taskTransfer);

        // Assert
        $this->tester->assertTaskResponseReturnedError(
            $createTaskResponse,
            'An error occurred while creating the task',
        );
    }

    public function testUpdateTaskMustChangeTaskAttributesSuccessfully(): void
    {
        // Arrange
        $taskTransfer = $this->tester->haveTask();
        $taskTransfer->setTitle('changed-title');
        $taskTransfer->setDescription('changed-title');
        $taskTransfer->setStatus('in_progress');
        $taskTransfer->setDueAt(date('Y-m-d H:i:s'));

        // Act
        $updateTaskResponse = $this->tester->getFacade()->updateTask($taskTransfer);

        // Assert
        $this->tester->assertUpdateTaskResponseIsCorrect($updateTaskResponse, $taskTransfer);
    }

    public function testUpdateTaskMustHandleUnexpectedExceptionSuccessfully(): void
    {
        // Arrange
        $taskTransfer = $this->tester->getTaskTransfer();

        $this->tester->mockEntityManagerUpdateTaskWithException();

        // Act
        $createTaskResponse = $this->tester->getFacade()->updateTask($taskTransfer);

        // Assert
        $this->tester->assertTaskResponseReturnedError(
            $createTaskResponse,
            'An error occurred while updating the task',
        );
    }

    public function testUpdateTaskMustHandleNotFoundTaskSuccessfully(): void
    {
        // Arrange
        $taskTransfer = $this->tester->haveTask();
        $taskTransfer->setIdTask(
            $taskTransfer->getIdTask() + 1
        );

        // Act
        $updateTaskResponse = $this->tester->getFacade()->updateTask($taskTransfer);

        // Assert
        $this->tester->assertTaskResponseReturnedError(
            $updateTaskResponse,
            'It\'s impossible to update this task.',
        );
    }

    public function testDeleteTaskMustRemoveTaskFromStorage(): void
    {
        // Arrange
        $taskTransfer = $this->tester->haveTask();

        // Act
        $deleteTaskResponse = $this->tester->getFacade()->deleteTask($taskTransfer);

        // Assert
        $this->tester->assertDeleteTaskResponseIsCorrect($deleteTaskResponse, $taskTransfer);
        $this->tester->assertDeleteTaskRemovedTask($taskTransfer);
    }

    public function testGetTaskByIdReturnsTaskSuccessfully(): void
    {
        // Arrange
        $taskTransfer = $this->tester->haveTask();

        // Act
        $getTaskResponse = $this->tester->getFacade()->getTaskById(
            $taskTransfer->getIdTask()
        );

        // Assert
        $this->tester->assertGetTaskByIdResponseIsCorrect($getTaskResponse, $taskTransfer);
    }

    public function testGetTaskByIdMustHandleNotFoundTaskSuccessfully(): void
    {
        // Act
        $getTaskResponse = $this->tester->getFacade()->getTaskById(0);

        // Assert
        $this->tester->assertTaskResponseReturnedError(
            $getTaskResponse,
            'Task not found.',
        );
    }

    public function testGetCollectionIsExecutedSuccessfully(): void
    {
        // Arrange
        $taskTransfer = $this->tester->haveTask();

        $taskCriteriaTransfer = new TaskCriteriaTransfer();

        // Act
        $taskCollectionTransfer = $this->tester->getFacade()->getTaskCollection(
            $taskCriteriaTransfer
        );

        // Assert
        $this->assertCount(1, $taskCollectionTransfer->getTasks());

        $this->tester->assertGetTaskCollectionResponseIsCorrect(
            $taskTransfer,
            $taskCollectionTransfer->getTasks()->getIterator()->current(),
        );
    }

    public function testGetCollectionFilterByTaskIdSuccessfully(): void
    {
        // Arrange
        $this->tester->haveTask();
        $this->tester->haveTask();
        $taskTransfer = $this->tester->haveTask();

        $taskConditions = new TaskConditionsTransfer();
        $taskConditions->addTaskId(
            $taskTransfer->getIdTask()
        );

        $taskCriteriaTransfer = new TaskCriteriaTransfer();
        $taskCriteriaTransfer->setTasksConditions($taskConditions);

        // Act
        $taskCollectionTransfer = $this->tester->getFacade()->getTaskCollection(
            $taskCriteriaTransfer
        );

        // Assert
        $this->assertCount(1, $taskCollectionTransfer->getTasks());

        $this->tester->assertGetTaskCollectionResponseIsCorrect(
            $taskTransfer,
            $taskCollectionTransfer->getTasks()->getIterator()->current(),
        );
    }

    public function testGetCollectionReturnTasksPaginatedSuccessfully(): void
    {
        // Arrange
        $this->tester->haveTask();
        $taskTransfer = $this->tester->haveTask();
        $this->tester->haveTask();

        $paginationTransfer = (new PaginationTransfer())
            ->setLimit(1)
            ->setOffset(1);

        $taskCriteriaTransfer = new TaskCriteriaTransfer();
        $taskCriteriaTransfer->setPagination($paginationTransfer);

        // Act
        $taskCollectionTransfer = $this->tester->getFacade()->getTaskCollection(
            $taskCriteriaTransfer
        );

        // Assert
        $this->assertCount(1, $taskCollectionTransfer->getTasks());

        $this->tester->assertGetTaskCollectionResponseIsCorrect(
            $taskTransfer,
            $taskCollectionTransfer->getTasks()->getIterator()->current(),
        );
    }

    public function testGetCollectionReturnTasksSortedSuccessfully(): void
    {
        // Arrange
        $taskTransfer3 = $this->tester->haveTask([TaskTransfer::TITLE => 'cccc']);
        $taskTransfer2 = $this->tester->haveTask([TaskTransfer::TITLE => 'bbbb']);
        $taskTransfer1 = $this->tester->haveTask([TaskTransfer::TITLE => 'aaaaa']);

        $sortTransfer = (new SortTransfer())
            ->setField(TaskTransfer::TITLE)
            ->setIsAscending(true);

        $taskCriteriaTransfer = new TaskCriteriaTransfer();
        $taskCriteriaTransfer->addSort($sortTransfer);

        // Act
        $taskCollectionTransfer = $this->tester->getFacade()->getTaskCollection(
            $taskCriteriaTransfer
        );

        // Assert
        $this->tester->assertGetTaskCollectionResponseIsCorrect(
            $taskTransfer1,
            $taskCollectionTransfer->getTasks()->getIterator()->offsetGet(0),
        );

        $this->tester->assertGetTaskCollectionResponseIsCorrect(
            $taskTransfer2,
            $taskCollectionTransfer->getTasks()->getIterator()->offsetGet(1),
        );

        $this->tester->assertGetTaskCollectionResponseIsCorrect(
            $taskTransfer3,
            $taskCollectionTransfer->getTasks()->getIterator()->offsetGet(2),
        );
    }
}
