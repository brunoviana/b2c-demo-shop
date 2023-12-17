<?php

namespace BrunoVianaTest\Glue\TasksBackendApi\Controller;

use BrunoViana\Glue\TasksBackendApi\Controller\TasksResourceController;
use BrunoVianaTest\Glue\TasksBackendApi\TasksBackendApiTester;
use Codeception\Test\Unit;
use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\GlueRequestUserTransfer;
use Generated\Shared\Transfer\GlueResourceTransfer;
use Generated\Shared\Transfer\TasksBackendApiAttributesTransfer;

class TasksResourceControllerTest extends Unit
{
    protected TasksBackendApiTester $tester;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tester->ensureTasksTableIsEmpty();
    }

    public function testGetCollectionReturnsTaskSuccessfully(): void
    {
        // Arrange
        $taskTransfer1 = $this->tester->haveTask();
        $taskTransfer2 = $this->tester->haveTask();
        $taskTransfer3 = $this->tester->haveTask();

        $adminUserTransfer = $this->tester->haveUser();

        $glueRequestTransfer = (new GlueRequestTransfer())->setRequestUser(
            (new GlueRequestUserTransfer())->setSurrogateIdentifier($adminUserTransfer->getIdUserOrFail()),
        );

        // Act
        $glueResponseTransfer = (new TasksResourceController())->getCollectionAction($glueRequestTransfer);

        // Assert
        $this->assertCount(0, $glueResponseTransfer->getErrors());
        $this->assertCount(3, $glueResponseTransfer->getResources());

        $this->tester->assertTaskTransfersAreTheSame(
            $taskTransfer1,
            $glueResponseTransfer->getResources()->offsetGet(0)->getAttributesOrFail(),
        );

        $this->tester->assertTaskTransfersAreTheSame(
            $taskTransfer2,
            $glueResponseTransfer->getResources()->offsetGet(1)->getAttributesOrFail(),
        );

        $this->tester->assertTaskTransfersAreTheSame(
            $taskTransfer3,
            $glueResponseTransfer->getResources()->offsetGet(2)->getAttributesOrFail(),
        );
    }

    public function testGetCollectionFilterByIdTaskSuccessfully(): void
    {
        // Arrange
        $this->tester->haveTask();
        $taskTransfer = $this->tester->haveTask();
        $this->tester->haveTask();

        $adminUserTransfer = $this->tester->haveUser();

        $glueRequestTransfer = (new GlueRequestTransfer())->setRequestUser(
            (new GlueRequestUserTransfer())->setSurrogateIdentifier($adminUserTransfer->getIdUserOrFail()),
        )->setResource(
            (new GlueResourceTransfer())->setId($taskTransfer->getIdTask()),
        );

        // Act
        $glueResponseTransfer = (new TasksResourceController())->getCollectionAction($glueRequestTransfer);

        // Assert
        $this->assertCount(0, $glueResponseTransfer->getErrors());
        $this->assertCount(1, $glueResponseTransfer->getResources());

        $this->tester->assertTaskTransfersAreTheSame(
            $taskTransfer,
            $glueResponseTransfer->getResources()->offsetGet(0)->getAttributesOrFail(),
        );
    }

    public function testGetActionReturnsTaskSuccessfully(): void
    {
        // Arrange
        $taskTranser = $this->tester->haveTask();

        $adminUserTransfer = $this->tester->haveUser();

        $glueRequestTransfer = (new GlueRequestTransfer())->setRequestUser(
            (new GlueRequestUserTransfer())->setSurrogateIdentifier($adminUserTransfer->getIdUserOrFail()),
        )->setResource(
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

        $adminUserTransfer = $this->tester->haveUser();

        $glueRequestTransfer = (new GlueRequestTransfer())->setRequestUser(
            (new GlueRequestUserTransfer())->setSurrogateIdentifier($adminUserTransfer->getIdUserOrFail()),
        )->setResource(
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

        $adminUserTransfer = $this->tester->haveUser();

        $glueRequestTransfer = (new GlueRequestTransfer())->setRequestUser(
            (new GlueRequestUserTransfer())->setSurrogateIdentifier($adminUserTransfer->getIdUserOrFail()),
        )->setResource(
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

        $adminUserTransfer = $this->tester->haveUser();

        $glueRequestTransfer = (new GlueRequestTransfer())->setRequestUser(
            (new GlueRequestUserTransfer())->setSurrogateIdentifier($adminUserTransfer->getIdUserOrFail()),
        )->setResource(
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

        $adminUserTransfer = $this->tester->haveUser();

        $glueRequestTransfer = (new GlueRequestTransfer())->setRequestUser(
            (new GlueRequestUserTransfer())->setSurrogateIdentifier($adminUserTransfer->getIdUserOrFail()),
        )->setResource(
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
        $adminUserTransfer = $this->tester->haveUser();

        $glueRequestTransfer = (new GlueRequestTransfer())->setRequestUser(
            (new GlueRequestUserTransfer())->setSurrogateIdentifier($adminUserTransfer->getIdUserOrFail()),
        )->setResource(
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
