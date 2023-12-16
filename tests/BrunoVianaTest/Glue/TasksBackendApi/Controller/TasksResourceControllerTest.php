<?php

namespace BrunoVianaTest\Glue\TasksBackendApi\Controller;

use BrunoViana\Glue\TasksBackendApi\Controller\TasksResourceController;
use BrunoVianaTest\Glue\TasksBackendApi\TasksBackendApiTester;
use Codeception\Test\Unit;
use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\GlueResourceTransfer;
use Generated\Shared\Transfer\TasksBackendApiAttributesTransfer;

class TasksResourceControllerTest extends Unit
{
    protected TasksBackendApiTester $tester;

    public function testGetActionReturnsTaskSuccessfully(): void
    {
        // Arrange
        $taskTranser = $this->tester->haveTask();

        $glueRequestTransfer = (new GlueRequestTransfer())->setResource(
            (new GlueResourceTransfer())->setId($taskTranser->getIdTask()),
        );

        // Act
        $glueResponseTransfer = (new TasksResourceController())->getAction($glueRequestTransfer);

        // Assert
        $this->tester->assertTaskResourceControllerGetActionReturnedGlueResponseProperly(
            $glueResponseTransfer,
            $taskTranser,
        );
    }

    public function testPostActionCreateTaskSuccessfully(): void
    {
        // Arrange
        $taskTransfer = $this->tester->createTaskTransfer();
        $taskBackendApiAttribute = (new TasksBackendApiAttributesTransfer())->fromArray($taskTransfer->toArray());
        $taskBackendApiAttribute->setIdTask(null);

        $glueRequestTransfer = (new GlueRequestTransfer())->setResource(
            (new GlueResourceTransfer())->setId($taskTransfer->getIdTask()),
        );

        // Act
        $glueResponseTransfer = (new TasksResourceController())->postAction(
            $taskBackendApiAttribute,
            $glueRequestTransfer
        );

        // Assert
        $this->tester->assertTaskResourceControllerPostActionReturnedGlueResponseProperly(
            $glueResponseTransfer,
            $taskTransfer,
        );
    }

    public function testPatchActionUpdateTaskSuccessfully(): void
    {
        // Arrange
        $taskTransfer = $this->tester->haveTask();
        $taskTransfer->setTitle('another-title');
        $taskTransfer->setDescription('another-title');
        $taskTransfer->setStatus('in_progress');

        $taskBackendApiAttribute = (new TasksBackendApiAttributesTransfer())->fromArray($taskTransfer->toArray());

        $glueRequestTransfer = (new GlueRequestTransfer())->setResource(
            (new GlueResourceTransfer())->setId($taskTransfer->getIdTask()),
        );

        // Act
        $glueResponseTransfer = (new TasksResourceController())->patchAction(
            $taskBackendApiAttribute,
            $glueRequestTransfer
        );

        // Assert
        $this->tester->assertTaskResourceControllerPatchActionReturnedGlueResponseProperly(
            $glueResponseTransfer,
            $taskTransfer,
        );
    }

    public function testPatchActionReturnsGlueResponseWithNotFoundIfTaskDoesntExist(): void
    {
        // Arrange
        $taskTransfer = $this->tester->createTaskTransfer();

        $taskBackendApiAttribute = (new TasksBackendApiAttributesTransfer())->fromArray($taskTransfer->toArray());

        $glueRequestTransfer = (new GlueRequestTransfer())->setResource(
            (new GlueResourceTransfer())->setId(-1),
        );

        // Act
        $glueResponseTransfer = (new TasksResourceController())->patchAction(
            $taskBackendApiAttribute,
            $glueRequestTransfer
        );

        // Assert
        $this->tester->assertTaskResourceControllerPatchActionReturnedGlueResponseProperlyWhenTaskDoesntExist(
            $glueResponseTransfer,
        );
    }

    public function testDeleteActionRemoveTaskSuccessfully(): void
    {
        // Arrange
        $taskTranser = $this->tester->haveTask();

        $glueRequestTransfer = (new GlueRequestTransfer())->setResource(
            (new GlueResourceTransfer())->setId($taskTranser->getIdTask()),
        );

        // Act
        $glueResponseTransfer = (new TasksResourceController())->deleteAction($glueRequestTransfer);

        // Assert
        $this->tester->assertTaskResourceControllerDeleteActionReturnedGlueResponseProperly(
            $glueResponseTransfer,
            $taskTranser,
        );
    }

    public function testDeleteActionReturnsGlueResponseWithNotFoundIfTaskDoesntExist(): void
    {
        // Arrange
        $glueRequestTransfer = (new GlueRequestTransfer())->setResource(
            (new GlueResourceTransfer())->setId(-1),
        );

        // Act
        $glueResponseTransfer = (new TasksResourceController())->deleteAction(
            $glueRequestTransfer
        );

        // Assert
        $this->tester->assertTaskResourceControllerDeleteActionReturnedGlueResponseProperlyWhenTaskDoesntExist(
            $glueResponseTransfer,
        );
    }
}
