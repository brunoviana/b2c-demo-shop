<?php

namespace BrunoViana\Zed\Tasks\Persistence;

use BrunoViana\Zed\Tasks\Persistence\Mapper\TaskMapperInterface;
use Orm\Zed\Tasks\Persistence\BvTaskQuery;
use BrunoViana\Zed\Tasks\Persistence\Mapper\TaskMapper;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \BrunoViana\Zed\Tasks\Persistence\TasksRepositoryInterface getRepository()
 * @method \BrunoViana\Zed\Tasks\Persistence\TasksEntityManagerInterface getEntityManager()
 * @method \BrunoViana\Zed\Tasks\TasksConfig getConfig()
 */
class TasksPersistenceFactory extends AbstractPersistenceFactory
{
    public function createTaskMapper(): TaskMapperInterface
    {
        return new TaskMapper();
    }

    public function createTaskQuery(): BvTaskQuery
    {
        return BvTaskQuery::create();
    }
}
