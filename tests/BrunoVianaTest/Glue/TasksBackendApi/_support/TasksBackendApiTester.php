<?php

declare(strict_types=1);

namespace BrunoVianaTest\Glue\TasksBackendApi;

use Generated\Shared\DataBuilder\TaskBuilder;
use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\GlueRequestUserTransfer;
use Generated\Shared\Transfer\GlueResourceTransfer;
use Generated\Shared\Transfer\GlueResponseTransfer;
use Generated\Shared\Transfer\TasksBackendApiAttributesTransfer;
use Generated\Shared\Transfer\TaskTransfer;
use Generated\Shared\Transfer\UserTransfer;

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
     * @param array<string, mixed> $seedData
     * @return TaskTransfer
     */
    public function createTaskTransfer(array $seedData = []): TaskTransfer
    {
        return (new TaskBuilder($seedData))->build();
    }

    public function createTaskTransferWithUser(
        UserTransfer $userTransfer,
        array $seedData = []
    ): TaskTransfer {
        return $this->createTaskTransfer([
            TaskTransfer::ID_ASSIGNEE => $userTransfer->getIdUser(),
            ...$seedData
        ]);
    }

    /**
     * @param UserTransfer $userTransfer
     * @param array<string, mixed> $seedData
     * @return TaskTransfer
     */
    public function haveTaskWithUser(
        UserTransfer $userTransfer,
        array $seedData = []
    ): TaskTransfer {
        return $this->haveTask([
            TaskTransfer::ID_ASSIGNEE => $userTransfer->getIdUser(),
            ...$seedData
        ]);
    }

    public function createTasksBackendApiAttributesTransferFromTaskTransfer(
        TaskTransfer $taskTransfer
    ): TasksBackendApiAttributesTransfer {
        return (new TasksBackendApiAttributesTransfer())->fromArray(
            $taskTransfer->toArray(),
            true
        );
    }

    public function createGlueRequestTransferWithUser(UserTransfer $userTransfer): GlueRequestTransfer
    {
        return (new GlueRequestTransfer())->setRequestUser(
            (new GlueRequestUserTransfer())
                ->setSurrogateIdentifier(
                    $userTransfer->getIdUserOrFail()
                ),
        );
    }

    public function addGlueResourceWithTaskIdToGlueRequest(
        GlueRequestTransfer $glueRequestTransfer,
        TaskTransfer $taskTransfer,
    ): GlueRequestTransfer {
        return $glueRequestTransfer->setResource(
            (new GlueResourceTransfer())->setId($taskTransfer->getIdTask()),
        );
    }

    public function assetGetCollectionReturnedGlueResponseWithSuccessfullData(
        GlueResponseTransfer $glueResponseTransfer,
        ...$expectedTaskTransfers
    ): void {
        $this->assertCount(0, $glueResponseTransfer->getErrors());
        $this->assertCount(count($expectedTaskTransfers), $glueResponseTransfer->getResources());

        foreach ($expectedTaskTransfers as $index => $expectedTaskTransfer) {
            $this->assertActualTaskTransfersIsSameAsExpetedTaskTransfer(
                $expectedTaskTransfer,
                $glueResponseTransfer->getResources()->offsetGet($index)->getAttributesOrFail(),
            );
        }
    }

    public function assertGetActionReturnedGlueResponseWithSuccessfullData(
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

        $this->assertActualTaskTransfersIsSameAsExpetedTaskTransfer(
            $expectedTaskTransfer,
            $tasksBackendApiAttributesTransfer,
        );
    }

    public function assertPostActionReturnedGlueResponseWithSuccessfullData(
        GlueResponseTransfer $glueResponseTransfer,
    ): void {
        $taskResource = $glueResponseTransfer->getResources()->getIterator()->current();
        $tasksBackendApiAttributesTransfer = $taskResource->getAttributesOrFail();

        $this->assertCount(0, $glueResponseTransfer->getErrors());
        $this->assertCount(1, $glueResponseTransfer->getResources());
        $this->assertNotNull($tasksBackendApiAttributesTransfer->getIdTask());
    }

    public function assertPatchActionReturnedGlueResponseWithSuccessfullData(
        GlueResponseTransfer $glueResponseTransfer,
        TaskTransfer $expectedTaskTransfer,
    ): void {
        $taskResource = $glueResponseTransfer->getResources()->getIterator()->current();
        $tasksBackendApiAttributesTransfer = $taskResource->getAttributesOrFail();

        $this->assertCount(0, $glueResponseTransfer->getErrors());
        $this->assertCount(1, $glueResponseTransfer->getResources());

        $this->assertSame(
            $expectedTaskTransfer->getIdTask(),
            $tasksBackendApiAttributesTransfer->getIdTask()
        );
    }

    public function assertGlueResponseHasNotFoundData(
        GlueResponseTransfer $glueResponseTransfer,
    ): void {
        $taskError = $glueResponseTransfer->getErrors()->getIterator()->current();

        $this->assertCount(1, $glueResponseTransfer->getErrors());
        $this->assertCount(0, $glueResponseTransfer->getResources());
        $this->assertEquals(404, $glueResponseTransfer->getHttpStatus());
        $this->assertEquals('Task not found.', $taskError->getMessage());
    }

    public function assertDeleteActionReturnedGlueResponseWithSuccessfullData(
        GlueResponseTransfer $glueResponseTransfer,
    ): void {
        $this->assertCount(0, $glueResponseTransfer->getErrors());
        $this->assertCount(0, $glueResponseTransfer->getResources());
    }

    public function assertActualTaskTransfersIsSameAsExpetedTaskTransfer(
        TaskTransfer $expectedTaskTransfer,
        TasksBackendApiAttributesTransfer $actualTaskTransfer,
    ): void {
        $this->assertSame(
            $expectedTaskTransfer->getTitle(),
            $actualTaskTransfer->getTitle(),
            'Returned task title not equals the expected value'
        );

        $this->assertSame(
            $expectedTaskTransfer->getDescription(),
            $actualTaskTransfer->getDescription(),
            'Returned task description not equals the expected value'
        );

        $this->assertSame(
            $expectedTaskTransfer->getStatus(),
            $actualTaskTransfer->getStatus(),
            'Returned task description not equals the expected value'
        );

        $this->assertEquals(
            new \DateTime($expectedTaskTransfer->getDueAt()),
            new \DateTime($actualTaskTransfer->getDueAt()),
            'Returned task due date not equals the expected value'
        );
    }

//    protected function assertTaskResourceControllerReturnedGlueResponseProperly(
//        GlueResponseTransfer $glueResponseTransfer,
//        TaskTransfer $expectedTaskTransfer,
//    ): void {
//        $this->assertCount(0, $glueResponseTransfer->getErrors());
//        $this->assertCount(1, $glueResponseTransfer->getResources());
//
//        $taskResource = $glueResponseTransfer->getResources()->getIterator()->current();
//        $tasksBackendApiAttributesTransfer = $taskResource->getAttributesOrFail();
//
//        $this->assertNotNull($taskResource->getId());
//        $this->assertNotNull($taskResource->getAttributes());
//
//        $this->assertTaskTransfersAreTheSame(
//            $expectedTaskTransfer,
//            $tasksBackendApiAttributesTransfer
//        );
//    }
}
