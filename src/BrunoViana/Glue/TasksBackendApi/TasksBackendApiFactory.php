<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace BrunoViana\Glue\TasksBackendApi;

use BrunoViana\Glue\TasksBackendApi\Dependency\Facade\TaskBackendApiToTasksFacadeInterface;
use BrunoViana\Glue\TasksBackendApi\Mapper\GlueRequestTaskMapper;
use BrunoViana\Glue\TasksBackendApi\Mapper\GlueRequestTaskMapperInterface;
use BrunoViana\Glue\TasksBackendApi\Mapper\GlueResponseTaskMapper;
use BrunoViana\Glue\TasksBackendApi\Mapper\GlueResponseTaskMapperInterface;
use BrunoViana\Glue\TasksBackendApi\Mapper\TasksBackendApiAttributesMapper;
use BrunoViana\Glue\TasksBackendApi\Mapper\TasksBackendApiAttributesMapperInterface;
use BrunoViana\Glue\TasksBackendApi\Processor\Mapper\TaskMapper;
use BrunoViana\Glue\TasksBackendApi\Processor\Mapper\TaskMapperInterface;
use BrunoViana\Glue\TasksBackendApi\Processor\Reader\TaskReader;
use BrunoViana\Glue\TasksBackendApi\Processor\Reader\TaskReaderInterface;
use BrunoViana\Glue\TasksBackendApi\Processor\Writer\TaskWriter;
use BrunoViana\Glue\TasksBackendApi\Processor\Writer\TaskWriterInterface;
use BrunoViana\Glue\TasksBackendApi\Validator\TasksBackendApiAttributesValidator;
use BrunoViana\Glue\TasksBackendApi\Validator\TasksBackendApiAttributesValidatorInterface;
use Spryker\Glue\Kernel\Backend\AbstractFactory;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TasksBackendApiFactory extends AbstractFactory
{

    public function createTaskReader(): TaskReaderInterface
    {
        return new TaskReader(
            $this->getTasksFacade(),
            $this->createGlueResponseTaskMapper(),
        );
    }

    public function createTaskWriter(): TaskWriterInterface
    {
        return new TaskWriter(
            $this->getTasksFacade(),
            $this->createTaskBackendApiAttributesMapper(),
            $this->createGlueResponseTaskMapper(),
            $this->createTasksBackendApiAttributesValidator(),
        );
    }

    public function createGlueResponseTaskMapper(): GlueResponseTaskMapperInterface
    {
        return new GlueResponseTaskMapper(
            $this->createTaskBackendApiAttributesMapper(),
        );
    }

    public function createGlueRequestTaskMapper(): GlueRequestTaskMapperInterface
    {
        return new GlueRequestTaskMapper(
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

    public function createTasksBackendApiAttributesValidator(): TasksBackendApiAttributesValidatorInterface
    {
        return new TasksBackendApiAttributesValidator(
            $this->getValidator()
        );
    }

    public function getValidator(): ValidatorInterface
    {
        return Validation::createValidator();
    }
}
