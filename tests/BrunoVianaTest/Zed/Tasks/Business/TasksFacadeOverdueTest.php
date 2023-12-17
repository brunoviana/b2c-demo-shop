<?php

namespace BrunoVianaTest\Zed\Tasks\Business;

use BrunoViana\Zed\Tasks\Dependency\Facade\TasksToMailFacadeInterface;
use BrunoViana\Zed\Tasks\Dependency\Facade\TasksToUserFacadeInterface;
use BrunoViana\Zed\Tasks\TasksDependencyProvider;
use Codeception\Stub;
use Codeception\Test\Unit;
use Generated\Shared\Transfer\TaskTransfer;
use BrunoVianaTest\Zed\Tasks\TasksBusinessTester;

class TasksFacadeOverdueTest extends Unit
{

    protected TasksBusinessTester $tester;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tester->ensureTasksTableIsEmpty();

        $this->tester->setDependency(
            TasksDependencyProvider::FACADE_MAIL,
            $this->getMailFacadeMock()
        );

        $this->tester->setDependency(
            TasksDependencyProvider::USER_MAIL,
            $this->getUserFacadeMock()
        );
    }

    public function testSendOverdueEmailMustSendEmailOnlyForOverdueTasks(): void
    {
        // Arrange
        $this->tester->haveTaskWithUser([
            TaskTransfer::DUE_AT => date('Y-m-d',strtotime("+1 days")),
        ]);

        $this->tester->haveTaskWithUser([
            TaskTransfer::DUE_AT => date('Y-m-d',strtotime("+7 days")),
        ]);

        $this->tester->haveTaskWithUser([
            TaskTransfer::DUE_AT => date('Y-m-d',strtotime("-1 days")),
        ]);

        // Act
        $sendOverdueTaskResponse = $this->tester->getFacade()->sendOverdueEmails();

        // Assert
        $this->assertSame(1, $sendOverdueTaskResponse->getCount());
    }

    protected function getMailFacadeMock(): TasksToMailFacadeInterface
    {
        /** @var TasksToUserFacadeInterface $mailFacadeMock */
        $mailFacadeMock = Stub::makeEmpty(TasksToMailFacadeInterface::class);

        return $mailFacadeMock;
    }

    protected function getUserFacadeMock(): TasksToUserFacadeInterface
    {
        /** @var TasksToUserFacadeInterface $userFacadeMock */
        $userFacadeMock = Stub::makeEmpty(TasksToUserFacadeInterface::class);

        return $userFacadeMock;
    }
}
