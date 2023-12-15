<?php

namespace BrunoVianaTest\Zed\Tasks\Helper;

use Codeception\Module;
use Generated\Shared\Transfer\TaskResponseTransfer;
use Generated\Shared\Transfer\TaskTransfer;

class TasksBusinessAssertionHelper extends Module
{

    public function assertCreateTaskResponseIsCorrect(
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

    public function assertUpdateTaskResponseIsCorrect(
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

        $this->assertEquals(
            $originalTaskTransfer->getTitle(),
            $updatedTaskTransfer->getTitle(),
            'Updated task must have the same title as original task',
        );

        $this->assertEquals(
            $originalTaskTransfer->getDescription(),
            $updatedTaskTransfer->getDescription(),
            'Updated task must have the same description as original task',
        );

        $this->assertEquals(
            $originalTaskTransfer->getStatus(),
            $updatedTaskTransfer->getStatus(),
            'Updated task must have the same status as original task',
        );

        $this->assertEquals(
            new \Datetime($originalTaskTransfer->getDueAt()),
            new \DateTime($updatedTaskTransfer->getDueAt()),
            'Updated task must have the same due date as original task',
        );
    }

    public function assertDeleteTaskResponseIsCorrect(
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

    public function assertGetTaskByIdResponseIsCorrect(
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
}
