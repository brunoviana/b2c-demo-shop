<?php

namespace BrunoVianaTest\Glue\TasksBackendApi\Controller;

use BrunoViana\Glue\TasksBackendApi\Controller\TasksResourceController;
use BrunoVianaTest\Glue\TasksBackendApi\TasksBackendApiTester;
use Codeception\Test\Unit;
use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\GlueRequestUserTransfer;
use Generated\Shared\Transfer\GlueResourceTransfer;
use Generated\Shared\Transfer\TasksBackendApiAttributesTransfer;
use Generated\Shared\Transfer\TaskTransfer;

class TasksResourceControllerTest extends Unit
{
    protected TasksBackendApiTester $tester;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tester->ensureTasksTableIsEmpty();
    }

    public function testGetCollectionShouldReturnAllUserTasksIfNoCriteriaIsProvided(): void
    {
        // Arrange
        $adminUserTransfer = $this->tester->haveUser();

        $taskTransfer1 = $this->tester->haveTaskWithUser($adminUserTransfer);
        $taskTransfer2 = $this->tester->haveTaskWithUser($adminUserTransfer);
        $taskTransfer3 = $this->tester->haveTaskWithUser($adminUserTransfer);

        $glueRequestTransfer = $this->tester->createGlueRequestTransferWithUser(
            $adminUserTransfer
        );

        // Act
        $glueResponseTransfer = (new TasksResourceController())->getCollectionAction($glueRequestTransfer);

        // Assert
        $this->tester->assetGetCollectionReturnedGlueResponseWithSuccessfullData(
            $glueResponseTransfer,
            $taskTransfer1,
            $taskTransfer2,
            $taskTransfer3,
        );
    }

    public function testGetCollectionShouldReturnUserTasksFilteredByIdIfCriteriaIsProvided(): void
    {
        // Arrange
        $adminUserTransfer = $this->tester->haveUser();

        $this->tester->haveTaskWithUser($adminUserTransfer);
        $taskTransfer = $this->tester->haveTaskWithUser($adminUserTransfer);
        $this->tester->haveTaskWithUser($adminUserTransfer);

        $glueRequestTransfer = $this->tester->createGlueRequestTransferWithUser($adminUserTransfer);
        $glueRequestTransfer = $this->tester->addGlueResourceWithTaskIdToGlueRequest($glueRequestTransfer, $taskTransfer);

        // Act
        $glueResponseTransfer = (new TasksResourceController())->getCollectionAction($glueRequestTransfer);

        // Assert
        $this->tester->assetGetCollectionReturnedGlueResponseWithSuccessfullData(
            $glueResponseTransfer,
            $taskTransfer,
        );
    }

    public function testGetActionShouldReturnUserTaskByTaskId(): void
    {
        // Arrange
        $adminUserTransfer = $this->tester->haveUser();
        $taskTransfer = $this->tester->haveTaskWithUser($adminUserTransfer);

        $glueRequestTransfer = $this->tester->createGlueRequestTransferWithUser($adminUserTransfer);
        $glueRequestTransfer = $this->tester->addGlueResourceWithTaskIdToGlueRequest($glueRequestTransfer, $taskTransfer);

        // Act
        $glueResponseTransfer = (new TasksResourceController())->getAction($glueRequestTransfer);

        // Assert
        $this->tester->assertGetActionReturnedGlueResponseWithSuccessfullData(
            $glueResponseTransfer,
            $taskTransfer,
        );
    }

    public function testPostActionShouldCreateUserTaskSuccessfully(): void
    {
        // Arrange
        $adminUserTransfer = $this->tester->haveUser();
        $taskTransfer = $this->tester->createTaskTransferWithUser($adminUserTransfer);

        $taskBackendApiAttribute = $this->tester->createTasksBackendApiAttributesTransferFromTaskTransfer($taskTransfer);
        $taskBackendApiAttribute->setIdTask(null);

        $glueRequestTransfer = $this->tester->createGlueRequestTransferWithUser($adminUserTransfer);
        $glueRequestTransfer = $this->tester->addGlueResourceWithTaskIdToGlueRequest($glueRequestTransfer, $taskTransfer);

        // Act
        $glueResponseTransfer = (new TasksResourceController())->postAction(
            $taskBackendApiAttribute,
            $glueRequestTransfer
        );

        // Assert
        $this->tester->assertPostActionReturnedGlueResponseWithSuccessfullData(
            $glueResponseTransfer,
        );

        $this->tester->assertActualTaskTransfersIsSameAsExpetedTaskTransfer(
            $taskTransfer,
            $glueResponseTransfer->getResources()->getIterator()->current()->getAttributes()
        );
    }

    /**
     * @return void
     * @dataProvider taskAttributesForPatchProvider
     */
    public function testPatchActionShouldUpdateUserTaskSuccessfully(
        array $attributeToChange
    ): void {
        // Arrange
        $adminUserTransfer = $this->tester->haveUser();
        $taskTransfer = $this->tester->haveTaskWithUser($adminUserTransfer);

        $taskTransfer->fromArray($attributeToChange);

        $taskBackendApiAttribute = $this->tester->createTasksBackendApiAttributesTransferFromTaskTransfer($taskTransfer);

        $glueRequestTransfer = $this->tester->createGlueRequestTransferWithUser($adminUserTransfer);
        $glueRequestTransfer = $this->tester->addGlueResourceWithTaskIdToGlueRequest($glueRequestTransfer, $taskTransfer);

        // Act
        $glueResponseTransfer = (new TasksResourceController())->patchAction(
            $taskBackendApiAttribute,
            $glueRequestTransfer
        );

        // Assert
        $this->tester->assertPatchActionReturnedGlueResponseWithSuccessfullData(
            $glueResponseTransfer,
            $taskTransfer,
        );

        $this->tester->assertActualTaskTransfersIsSameAsExpetedTaskTransfer(
            $taskTransfer,
            $glueResponseTransfer->getResources()->getIterator()->current()->getAttributes()
        );
    }

    public function testPatchActionShouldReturnNotFoundIfTaskDoesntExist(): void
    {
        // Arrange
        $adminUserTransfer = $this->tester->haveUser();
        $taskTransfer = $this->tester->createTaskTransferWithUser($adminUserTransfer);

        $taskTransfer->setIdTask(-1);

        $taskBackendApiAttribute = $this->tester->createTasksBackendApiAttributesTransferFromTaskTransfer($taskTransfer);

        $glueRequestTransfer = $this->tester->createGlueRequestTransferWithUser($adminUserTransfer);
        $glueRequestTransfer = $this->tester->addGlueResourceWithTaskIdToGlueRequest($glueRequestTransfer, $taskTransfer);

        // Act
        $glueResponseTransfer = (new TasksResourceController())->patchAction(
            $taskBackendApiAttribute,
            $glueRequestTransfer
        );

        // Assert
        $this->tester->assertGlueResponseHasNotFoundData(
            $glueResponseTransfer,
        );
    }

    public function testDeleteActionShouldRemoveUserTaskFromStorage(): void
    {
        // Arrange
        $adminUserTransfer = $this->tester->haveUser();
        $taskTransfer = $this->tester->haveTaskWithUser($adminUserTransfer);

        $glueRequestTransfer = $this->tester->createGlueRequestTransferWithUser($adminUserTransfer);
        $glueRequestTransfer = $this->tester->addGlueResourceWithTaskIdToGlueRequest($glueRequestTransfer, $taskTransfer);

        // Act
        $glueResponseTransfer = (new TasksResourceController())->deleteAction($glueRequestTransfer);

        // Assert
        $this->tester->assertDeleteActionReturnedGlueResponseWithSuccessfullData(
            $glueResponseTransfer
        );
    }

    public function testDeleteActionShouldReturnNotFoundIfTaskDoesntExist(): void
    {
        // Arrange
        $adminUserTransfer = $this->tester->haveUser();
        $taskTransfer = $this->tester->createTaskTransferWithUser($adminUserTransfer);

        $taskTransfer->setIdTask(-1);

        $taskBackendApiAttribute = $this->tester->createTasksBackendApiAttributesTransferFromTaskTransfer($taskTransfer);

        $glueRequestTransfer = $this->tester->createGlueRequestTransferWithUser($adminUserTransfer);
        $glueRequestTransfer = $this->tester->addGlueResourceWithTaskIdToGlueRequest($glueRequestTransfer, $taskTransfer);

        // Act
        $glueResponseTransfer = (new TasksResourceController())->deleteAction(
            $glueRequestTransfer
        );

        // Assert
        $this->tester->assertGlueResponseHasNotFoundData(
            $glueResponseTransfer,
        );
    }

    public function testGetCollectionShouldReturnForbiddenIfUserNotLogged(): void
    {
        // Arrange
        $glueRequestTransfer = $this->tester->createGlueRequestTransferWithoutUser();

        // Act
        $glueResponseTransfer = (new TasksResourceController())->getCollectionAction($glueRequestTransfer);

        // Assert
        $this->tester->assertGlueResponseHasForbiddenData($glueResponseTransfer);
    }

    public function testGetActionShouldReturnForbiddenIfUserNotLogged(): void
    {
        // Arrange
        $adminUserTransfer = $this->tester->haveUser();
        $taskTransfer = $this->tester->haveTaskWithUser($adminUserTransfer);

        $glueRequestTransfer = $this->tester->createGlueRequestTransferWithoutUser();
        $glueRequestTransfer = $this->tester->addGlueResourceWithTaskIdToGlueRequest($glueRequestTransfer, $taskTransfer);

        // Act
        $glueResponseTransfer = (new TasksResourceController())->getAction($glueRequestTransfer);

        // Assert
        $this->tester->assertGlueResponseHasForbiddenData($glueResponseTransfer);
    }

    public function testPostActionShouldReturnForbiddenIfUserNotLogged(): void
    {
        // Arrange
        $adminUserTransfer = $this->tester->haveUser();
        $taskTransfer = $this->tester->createTaskTransferWithUser($adminUserTransfer);

        $taskBackendApiAttribute = $this->tester->createTasksBackendApiAttributesTransferFromTaskTransfer($taskTransfer);
        $taskBackendApiAttribute->setIdTask(null);

        $glueRequestTransfer = $this->tester->createGlueRequestTransferWithoutUser();
        $glueRequestTransfer = $this->tester->addGlueResourceWithTaskIdToGlueRequest($glueRequestTransfer, $taskTransfer);

        // Act
        $glueResponseTransfer = (new TasksResourceController())->postAction(
            $taskBackendApiAttribute,
            $glueRequestTransfer
        );

        // Assert
        $this->tester->assertGlueResponseHasForbiddenData($glueResponseTransfer);
    }

    public function testPatchActionShouldReturnForbiddenIfUserNotLogged(): void
    {
        // Arrange
        $adminUserTransfer = $this->tester->haveUser();
        $taskTransfer = $this->tester->haveTaskWithUser($adminUserTransfer);

        $taskTransfer->setTitle('changed title');

        $taskBackendApiAttribute = $this->tester->createTasksBackendApiAttributesTransferFromTaskTransfer($taskTransfer);

        $glueRequestTransfer = $this->tester->createGlueRequestTransferWithoutUser();
        $glueRequestTransfer = $this->tester->addGlueResourceWithTaskIdToGlueRequest($glueRequestTransfer, $taskTransfer);

        // Act
        $glueResponseTransfer = (new TasksResourceController())->patchAction(
            $taskBackendApiAttribute,
            $glueRequestTransfer
        );

        // Assert
        $this->tester->assertGlueResponseHasForbiddenData($glueResponseTransfer);
    }

    public function testDeleteActionShouldReturnForbiddenIfUserNotLogged(): void
    {
        // Arrange
        $adminUserTransfer = $this->tester->haveUser();
        $taskTransfer = $this->tester->haveTaskWithUser($adminUserTransfer);

        $glueRequestTransfer = $this->tester->createGlueRequestTransferWithoutUser();
        $glueRequestTransfer = $this->tester->addGlueResourceWithTaskIdToGlueRequest($glueRequestTransfer, $taskTransfer);

        // Act
        $glueResponseTransfer = (new TasksResourceController())->deleteAction($glueRequestTransfer);

        // Assert
        $this->tester->assertGlueResponseHasForbiddenData($glueResponseTransfer);
    }

    // @TODO validate user permission

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
