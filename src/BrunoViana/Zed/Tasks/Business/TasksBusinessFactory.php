<?php

namespace BrunoViana\Zed\Tasks\Business;

use BrunoViana\Zed\Tasks\Business\EmailSender\OverdueEmailSender;
use BrunoViana\Zed\Tasks\Business\EmailSender\OverdueEmailSenderInterface;
use BrunoViana\Zed\Tasks\Business\Reader\TaskReader;
use BrunoViana\Zed\Tasks\Business\Reader\TaskReaderInterface;
use BrunoViana\Zed\Tasks\Business\Writer\TaskWriter;
use BrunoViana\Zed\Tasks\Business\Writer\TaskWriterInterface;
use BrunoViana\Zed\Tasks\Dependency\Facade\TasksToMailFacadeInterface;
use BrunoViana\Zed\Tasks\Dependency\Facade\TasksToUserFacadeInterface;
use BrunoViana\Zed\Tasks\TasksDependencyProvider;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \BrunoViana\Zed\Tasks\Persistence\TasksEntityManagerInterface getEntityManager()()
 * @method \BrunoViana\Zed\Tasks\Persistence\TasksRepositoryInterface getRepository()
 * @method \BrunoViana\Zed\Tasks\TasksConfig getConfig()
 */
class TasksBusinessFactory extends AbstractBusinessFactory
{
    public function createTaskWriter(): TaskWriterInterface
    {
        return new TaskWriter(
            $this->getEntityManager(),
        );
    }

    public function createTaskReader(): TaskReaderInterface
    {
        return new TaskReader(
            $this->getRepository(),
        );
    }

    public function createOverdueEmailSender(): OverdueEmailSenderInterface
    {
        return new OverdueEmailSender(
            $this->getRepository(),
            $this->getMailFacade(),
            $this->getUserFacade(),
        );
    }

    public function getMailFacade(): TasksToMailFacadeInterface
    {
        return $this->getProvidedDependency(TasksDependencyProvider::FACADE_MAIL);
    }

    public function getUserFacade(): TasksToUserFacadeInterface
    {
        return $this->getProvidedDependency(TasksDependencyProvider::USER_MAIL);
    }
}
