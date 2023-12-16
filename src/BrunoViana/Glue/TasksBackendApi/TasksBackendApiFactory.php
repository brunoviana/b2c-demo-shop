<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace BrunoViana\Glue\TasksBackendApi;

use BrunoViana\Glue\TasksBackendApi\Dependency\Facade\TaskBackendApiToTasksFacadeInterface;
use BrunoViana\Glue\TasksBackendApi\Mapper\GlueResponseTaskMapper;
use BrunoViana\Glue\TasksBackendApi\Mapper\GlueResponseTaskMapperInterface;
use BrunoViana\Glue\TasksBackendApi\Mapper\TasksBackendApiAttributesMapper;
use BrunoViana\Glue\TasksBackendApi\Mapper\TasksBackendApiAttributesMapperInterface;
use BrunoViana\Glue\TasksBackendApi\Processor\Mapper\TaskMapper;
use BrunoViana\Glue\TasksBackendApi\Processor\Mapper\TaskMapperInterface;
use BrunoViana\Glue\TasksBackendApi\Processor\Reader\TasksReader;
use BrunoViana\Glue\TasksBackendApi\Processor\Reader\TasksReaderInterface;
use Spryker\Glue\Kernel\Backend\AbstractFactory;

class TasksBackendApiFactory extends AbstractFactory
{

    public function createTaskReader(): TasksReaderInterface
    {
        return new TasksReader(
            $this->getTasksFacade(),
            $this->crateGlueResponseTaskMapper(),
        );
    }
    public function crateGlueResponseTaskMapper(): GlueResponseTaskMapperInterface
    {
        return new GlueResponseTaskMapper(
            $this->createTaskBackendApiAttributesMapper(),
        );
    }

    public function createTaskBackendApiAttributesMapper(): TasksBackendApiAttributesMapperInterface
    {
        return new TasksBackendApiAttributesMapper();
    }

    public function getTasksFacade(): TaskBackendApiToTasksFacadeInterface
    {
        return $this->getProvidedDependency(TasksBackendApiDependencyProvider::FACADE_TASKS);
    }
}
