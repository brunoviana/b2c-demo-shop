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

    public function testCreateTaskShouldCreateNewTaskSuccessfully(): void
    {
        // Arrange
        $taskTransfer = $this->tester->getTaskTransferWithUser();

        // Act
        $createTaskResponse = $this->tester->getFacade()->createTask($taskTransfer);

        // Assert
        $this->tester->assertTasksFacadeCreateTaskResponseHasRightDataForSuccessfullRequest(
            $createTaskResponse
        );

        $this->tester->assertActualTaskIsSameAsExpectedTask(
            $taskTransfer,
            $createTaskResponse->getTaskTransfer()
        );
    }

    public function testCreateTaskShouldHandleUnexpectedExceptionIfTaskCreationFails(): void
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

    /**
     * @return void
     * @dataProvider taskAttributesForPatchProvider
     */
    public function testUpdateTaskShouldPatchExistentTaskSuccessfully(
        array $attributeToChange
    ): void {
        // Arrange
        $taskTransfer = $this->tester->haveTaskWithUser();

        $taskTransfer->fromArray($attributeToChange);

        // Act
        $updateTaskResponse = $this->tester->getFacade()->updateTask($taskTransfer);

        // Assert
        $this->tester->assertTasksFacadeUpdateTaskResponseHasRightDataForSuccessfullRequest(
            $updateTaskResponse,
            $taskTransfer
        );

        $this->tester->assertActualTaskIsSameAsExpectedTask(
            $taskTransfer,
            $updateTaskResponse->getTaskTransfer()
        );
    }

    public function testUpdateTaskShouldHandleUnexpectedExceptionIfTaskPatchingFails(): void
    {
        // Arrange
        $taskTransfer = $this->tester->getTaskTransfer();

        $this->tester->mockEntityManagerUpdateTaskWithException();

        // Act
        $updateTaskResponse = $this->tester->getFacade()->updateTask($taskTransfer);

        // Assert
        $this->tester->assertTaskResponseReturnedError(
            $updateTaskResponse,
            'An error occurred while updating the task',
        );
    }

    public function testUpdateTaskShouldReturnExceptionIfTaskIsNotFound(): void
    {
        // Arrange
        $taskTransfer = $this->tester->getTaskTransfer();
        $taskTransfer->setIdTask(-1);

        // Act
        $updateTaskResponse = $this->tester->getFacade()->updateTask($taskTransfer);

        // Assert
        $this->tester->assertTaskResponseReturnedError(
            $updateTaskResponse,
            'It\'s impossible to update this task.',
        );
    }

    public function testDeleteTaskShouldRemoveTaskFromStorageSuccessfully(): void
    {
        // Arrange
        $taskTransfer = $this->tester->haveTaskWithUser();

        // Act
        $deleteTaskResponse = $this->tester->getFacade()->deleteTask($taskTransfer);

        // Assert
        $this->tester->assertTasksFacadeDeleteTaskResponseHasRightDataForSuccessfullRequest(
            $deleteTaskResponse,
            $taskTransfer
        );

        $this->tester->assertTaskDontExistInStorage($taskTransfer);
    }

    public function testGetTaskByIdShouldReturnExistentTaskByItsId(): void
    {
        // Arrange
        $taskTransfer = $this->tester->haveTaskWithUser();

        // Act
        $getTaskByIdResponse = $this->tester->getFacade()->getTaskById(
            $taskTransfer->getIdTask()
        );

        // Assert
        $this->tester->assertTasksFacadeGetTaskByIdResponseHasRightDataForSuccessfullRequest(
            $getTaskByIdResponse,
        );

        $this->tester->assertActualTaskIsSameAsExpectedTask(
            $taskTransfer,
            $getTaskByIdResponse->getTaskTransfer()
        );
    }

    public function testGetTaskByIdShouldReturnExceptionIfTaskIsNotFound(): void
    {
        // Act
        $getTaskResponse = $this->tester->getFacade()->getTaskById(0);

        // Assert
        $this->tester->assertTaskResponseReturnedError(
            $getTaskResponse,
            'Task not found.',
        );
    }

    public function testGetTaskCollectionShouldReturnAllTaskIfNoCriteriaIsDefined(): void
    {
        // Arrange
        $taskTransfer = $this->tester->haveTaskWithUser();

        $taskCriteriaTransfer = new TaskCriteriaTransfer();

        // Act
        $taskCollectionTransfer = $this->tester->getFacade()->getTaskCollection(
            $taskCriteriaTransfer
        );

        // Assert
        $this->tester->assertGetTaskCollectionResponseReturnedJustOneTask(
            $taskCollectionTransfer
        );

        $this->tester->assertActualTaskIsSameAsExpectedTask(
            $taskTransfer,
            $taskCollectionTransfer->getTasks()->getIterator()->current(),
        );
    }

    public function testGetTaskCollectionShouldReturnOneTaskFilteredById(): void
    {
        // Arrange
        $this->tester->haveTaskWithUser();
        $this->tester->haveTaskWithUser();
        $taskTransfer = $this->tester->haveTaskWithUser();

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
        $this->tester->assertGetTaskCollectionResponseReturnedJustOneTask(
            $taskCollectionTransfer
        );

        $this->tester->assertActualTaskIsSameAsExpectedTask(
            $taskTransfer,
            $taskCollectionTransfer->getTasks()->getIterator()->current(),
        );
    }

    public function testGetTaskCollectionShouldReturnPaginatedResultIfPaginationIsDefined(): void
    {
        // Arrange
        $this->tester->haveTaskWithUser();
        $taskTransfer = $this->tester->haveTaskWithUser();
        $this->tester->haveTaskWithUser();

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
        $this->tester->assertGetTaskCollectionResponseReturnedJustOneTask(
            $taskCollectionTransfer
        );

        $this->tester->assertActualTaskIsSameAsExpectedTask(
            $taskTransfer,
            $taskCollectionTransfer->getTasks()->getIterator()->current(),
        );
    }

    public function testGetTaskCollectionShouldReturnSortedResultIfSortIsDefined(): void
    {
        // Arrange
        $taskTransfer3 = $this->tester->haveTaskWithUser([TaskTransfer::TITLE => 'cccc']);
        $taskTransfer2 = $this->tester->haveTaskWithUser([TaskTransfer::TITLE => 'bbbb']);
        $taskTransfer1 = $this->tester->haveTaskWithUser([TaskTransfer::TITLE => 'aaaaa']);

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
        $this->tester->assertActualTaskIsSameAsExpectedTask(
            $taskTransfer1,
            $taskCollectionTransfer->getTasks()->getIterator()->offsetGet(0),
        );

        $this->tester->assertActualTaskIsSameAsExpectedTask(
            $taskTransfer2,
            $taskCollectionTransfer->getTasks()->getIterator()->offsetGet(1),
        );

        $this->tester->assertActualTaskIsSameAsExpectedTask(
            $taskTransfer3,
            $taskCollectionTransfer->getTasks()->getIterator()->offsetGet(2),
        );
    }

    public function taskAttributesForPatchProvider()
    {
        return [
            [[ TaskTransfer::TITLE => 'changed-title' ]],
            [[ TaskTransfer::DESCRIPTION => 'changed-description' ]],
            [[ TaskTransfer::STATUS => 'in_progress' ]],
            [[ TaskTransfer::DUE_AT => date('Y-m-d H:i:s') ]],
        ];
    }
}
