<?php

declare(strict_types=1);

namespace BrunoVianaTest\Glue\TasksBackendApi;

use Generated\Shared\DataBuilder\TaskBuilder;
use Generated\Shared\Transfer\GlueResourceTransfer;
use Generated\Shared\Transfer\GlueResponseTransfer;
use Generated\Shared\Transfer\TaskTransfer;

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
 * @SuppressWarnings(PHPMD)
*/
class TasksBackendApiTester extends \Codeception\Actor
{
    use _generated\TasksBackendApiTesterActions;

    /**
     * @param string[] $seedData
     * @return TaskTransfer
     */
    public function createTaskTransfer(array $seedData = []): TaskTransfer
    {
        return (new TaskBuilder($seedData))->build();
    }

    public function assertTaskResourceControllerGetActionReturnedGlueResponseProperly(
        GlueResponseTransfer $glueResponseTransfer,
        TaskTransfer $expectedTaskTransfer,
    ): void {
        $taskResource = $glueResponseTransfer->getResources()->getIterator()->current();
        $tasksBackendApiAttributesTransfer = $taskResource->getAttributesOrFail();

        $this->assertSame($expectedTaskTransfer->getIdTask(), $taskResource->getId());

        $this->assertSame(
            $expectedTaskTransfer->getIdTask(),
            $tasksBackendApiAttributesTransfer->getIdTask(),
            'Returned task id not equals the expected value'
        );

        $this->assertTaskResourceControllerReturnedGlueResponseProperly(
            $glueResponseTransfer,
            $expectedTaskTransfer
        );
    }

    public function assertTaskResourceControllerPostActionReturnedGlueResponseProperly(
        GlueResponseTransfer $glueResponseTransfer,
        TaskTransfer $expectedTaskTransfer,
    ): void {
        $this->assertTaskResourceControllerReturnedGlueResponseProperly(
            $glueResponseTransfer,
            $expectedTaskTransfer
        );
    }

    public function assertTaskResourceControllerPatchActionReturnedGlueResponseProperly(
        GlueResponseTransfer $glueResponseTransfer,
        TaskTransfer $expectedTaskTransfer,
    ): void {
        $this->assertTaskResourceControllerReturnedGlueResponseProperly(
            $glueResponseTransfer,
            $expectedTaskTransfer
        );
    }

    public function assertTaskResourceControllerPatchActionReturnedGlueResponseProperlyWhenTaskDoesntExist(
        GlueResponseTransfer $glueResponseTransfer,
    ): void {
        $this->assertCount(1, $glueResponseTransfer->getErrors());
        $this->assertCount(0, $glueResponseTransfer->getResources());
    }

    public function assertTaskResourceControllerDeleteActionReturnedGlueResponseProperly(
        GlueResponseTransfer $glueResponseTransfer,
        TaskTransfer $expectedTaskTransfer,
    ): void {
        $this->assertCount(0, $glueResponseTransfer->getErrors());
        $this->assertCount(0, $glueResponseTransfer->getResources());
    }

    public function assertTaskResourceControllerDeleteActionReturnedGlueResponseProperlyWhenTaskDoesntExist(
        GlueResponseTransfer $glueResponseTransfer,
    ): void {
        $this->assertCount(1, $glueResponseTransfer->getErrors());
        $this->assertCount(0, $glueResponseTransfer->getResources());
    }

    protected function assertTaskResourceControllerReturnedGlueResponseProperly(
        GlueResponseTransfer $glueResponseTransfer,
        TaskTransfer $expectedTaskTransfer,
    ): void {
        $this->assertCount(0, $glueResponseTransfer->getErrors());
        $this->assertCount(1, $glueResponseTransfer->getResources());

        $taskResource = $glueResponseTransfer->getResources()->getIterator()->current();
        $tasksBackendApiAttributesTransfer = $taskResource->getAttributesOrFail();

        $this->assertNotNull($taskResource->getId());
        $this->assertNotNull($taskResource->getAttributes());

        $this->assertSame(
            $expectedTaskTransfer->getTitle(),
            $tasksBackendApiAttributesTransfer->getTitle(),
            'Returned task title not equals the expected value'
        );

        $this->assertSame(
            $expectedTaskTransfer->getDescription(),
            $tasksBackendApiAttributesTransfer->getDescription(),
            'Returned task description not equals the expected value'
        );

        $this->assertSame(
            $expectedTaskTransfer->getStatus(),
            $tasksBackendApiAttributesTransfer->getStatus(),
            'Returned task description not equals the expected value'
        );

        $this->assertEquals(
            new \DateTime($expectedTaskTransfer->getDueAt()),
            new \DateTime($tasksBackendApiAttributesTransfer->getDueAt()),
            'Returned task due date not equals the expected value'
        );
    }
}
