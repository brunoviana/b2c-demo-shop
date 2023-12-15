<?php

namespace BrunoViana\Zed\Tasks\Business;

use BrunoViana\Zed\Tasks\Business\Writer\TaskWriter;
use BrunoViana\Zed\Tasks\Business\Writer\TaskWriterInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \BrunoViana\Zed\Tasks\Persistence\TasksEntityManagerInterface getEntityManager()()
 * @method \BrunoViana\Zed\Tasks\Persistence\TasksRepositoryInterface getRepository()
 * @method \BrunoViana\Zed\Tasks\Business\TasksConfig getConfig()
 */
class TasksBusinessFactory extends AbstractBusinessFactory
{
    public function createTaskWriter(): TaskWriterInterface
    {
        return new TaskWriter(
            $this->getEntityManager(),
        );
    }
}
