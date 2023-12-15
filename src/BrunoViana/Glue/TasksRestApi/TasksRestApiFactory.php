<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace BrunoViana\Glue\TasksRestApi;

use BrunoViana\Glue\TasksRestApi\Mapper\TaskMapper;
use BrunoViana\Glue\TasksRestApi\Mapper\TaskMapperInterface;
use BrunoViana\Glue\TasksRestApi\RestResponseBuilder\TaskRestResponseBuilder;
use BrunoViana\Glue\TasksRestApi\RestResponseBuilder\TaskRestResponseBuilderInterface;
use Spryker\Glue\Kernel\Backend\AbstractFactory;

class TasksRestApiFactory extends AbstractFactory
{
    /**
     * @return \BrunoViana\Glue\TasksRestApi\Mapper\TaskMapperInterface
     */
    public function createTaskMapper(): TaskMapperInterface
    {
        return new TaskMapper();
    }

    /**
     * @return \BrunoViana\Glue\TasksRestApi\RestResponseBuilder\TaskRestResponseBuilderInterface
     */
    public function createTaskRestResponseBuilder(): TaskRestResponseBuilderInterface
    {
        return new TaskRestResponseBuilder($this->getResourceBuilder(), $this->createTaskMapper());
    }
}
