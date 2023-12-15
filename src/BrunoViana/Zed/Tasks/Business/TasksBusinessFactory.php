<?php

namespace BrunoViana\Zed\Tasks\Business;

use BrunoViana\Zed\Tasks\Business\Reader\TaskReader;
use BrunoViana\Zed\Tasks\Business\Reader\TaskReaderInterface;
use BrunoViana\Zed\Tasks\Business\Writer\TaskWriter;
use BrunoViana\Zed\Tasks\Business\Writer\TaskWriterInterface;
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
}
