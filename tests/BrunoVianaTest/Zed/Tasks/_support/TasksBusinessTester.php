<?php

declare(strict_types=1);

namespace BrunoVianaTest\Zed\Tasks;

use Codeception\Stub;
use Exception;
use Generated\Shared\DataBuilder\TaskBuilder;
use Generated\Shared\Transfer\TaskResponseTransfer;
use Generated\Shared\Transfer\TaskTransfer;
use BrunoViana\Zed\Tasks\Persistence\TasksEntityManagerInterface;

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
 * @method \BrunoViana\Zed\Tasks\Business\TasksFacadeInterface getFacade()
 *
 * @SuppressWarnings(PHPMD)
*/
class TasksBusinessTester extends \Codeception\Actor
{
    use _generated\TasksBusinessTesterActions;

    /**
     * @param string[] $seedData
     * @return TaskTransfer
     */
    public function getTaskTransfer(array $seedData = []): TaskTransfer
    {
        return (new TaskBuilder($seedData))->build();
    }

    /**
     * @throws Exception
     */
    public function mockEntityManagerCreateTaskWithException(): void
    {
        $taxAppEntityManagerMock = Stub::makeEmpty(TasksEntityManagerInterface::class, [
            'createTask' => function (): void {
                throw new Exception('something went wrong');
            },
        ]);

        $this->mockFactoryMethod('getEntityManager', $taxAppEntityManagerMock);
    }

    /**
     * @throws Exception
     */
    public function mockEntityManagerUpdateTaskWithException(): void
    {
        $taxAppEntityManagerMock = Stub::makeEmpty(TasksEntityManagerInterface::class, [
            'updateTask' => function (): void {
                throw new Exception('something went wrong');
            },
        ]);

        $this->mockFactoryMethod('getEntityManager', $taxAppEntityManagerMock);
    }
}
