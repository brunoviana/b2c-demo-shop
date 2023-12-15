<?php

namespace BrunoVianaTest\Zed\Tasks\Business;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\TaskTransfer;
use BrunoVianaTest\Zed\Tasks\TasksBusinessTester;
use Spryker\Shared\Kernel\Transfer\Exception\RequiredTransferPropertyException;

class TasksFacadeTest extends Unit
{

    protected TasksBusinessTester $tester;

    public function testCreateTaskIsExecutedSuccessfully(): void
    {
        // Arrange
        $taskTransfer = $this->tester->getTaskTransfer();

        // Act
        $createTaskResponse = $this->tester->getFacade()->createTask($taskTransfer);

        // Assert
        $this->tester->assertCreateTaskCreatedTaskSuccessfully($createTaskResponse);
    }

    public function testCreateTaskMustValidateIfTitleIsMissing(): void
    {
        // Assert
        $this->expectException(RequiredTransferPropertyException::class);

        // Arrange
        $taskTransfer = $this->tester->getTaskTransfer([
            'title' => null,
        ]);

        // Act
        $this->tester->getFacade()->createTask($taskTransfer);
    }

    public function testCreateTaskMustValidateIfStatusIsMissing(): void
    {
        // Assert
        $this->expectException(RequiredTransferPropertyException::class);

        // Arrange
        $taskTransfer = $this->tester->getTaskTransfer([
            'status' => null,
        ]);

        // Act
        $this->tester->getFacade()->createTask($taskTransfer);
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
        $this->tester->assertUpdateTaskChangeTaskAttributesSuccessfully($updateTaskResponse, $taskTransfer);
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

    public function testUpdateTaskMustHandleNotFoundTasksSuccessfully(): void
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
            'It\' impossible to update this task.',
        );
    }

}
