<?php

namespace BrunoViana\Zed\Tasks\Dependency\Facade;

use Generated\Shared\Transfer\UserTransfer;
use Spryker\Zed\User\Business\UserFacadeInterface;

class TasksToUserFacadeBridge implements TasksToUserFacadeInterface
{
    public function __construct(
        protected UserFacadeInterface $userFacade,
    ) {}

    public function getUserById($idUser): UserTransfer
    {
        return $this->userFacade->getUserById();
    }
}
