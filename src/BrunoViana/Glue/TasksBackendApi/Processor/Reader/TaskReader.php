<?php

namespace BrunoViana\Glue\TasksBackendApi\Processor\Reader;

use BrunoViana\Glue\TasksBackendApi\Dependency\Facade\TaskBackendApiToTasksFacadeInterface;
use BrunoViana\Glue\TasksBackendApi\Mapper\GlueResponseTaskMapperInterface;
use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\GlueResponseTransfer;
use Generated\Shared\Transfer\TaskConditionsTransfer;
use Generated\Shared\Transfer\TaskCriteriaTransfer;

class TaskReader implements TaskReaderInterface
{
    public function __construct(
        protected TaskBackendApiToTasksFacadeInterface $tasksFacade,
        protected GlueResponseTaskMapperInterface $responseMapper,
    ) {}

    public function getTaskCollection(
        GlueRequestTransfer $glueRequestTransfer
    ): GlueResponseTransfer {

        $taskCriteriaTransfer = $this->createTaskCriteriaTransfer($glueRequestTransfer);
        $tasksCollectionTransfer = $this->tasksFacade->getTaskCollection($taskCriteriaTransfer);

        return $this->responseMapper->mapTaskResponseCollectionToGlueResponseTransfer(
            $tasksCollectionTransfer,
            $glueRequestTransfer
        );
    }

    protected function createTaskCriteriaTransfer(
        GlueRequestTransfer $glueRequestTransfer,
    ): TaskCriteriaTransfer {
        $taskCriteriaTransfer = new TaskCriteriaTransfer();
        $taskConditions = new TaskConditionsTransfer();

        if ($glueRequestTransfer->getResource() && $glueRequestTransfer->getResourceOrFail()->getId()) {
            $taskConditions->addTaskId($glueRequestTransfer->getResourceOrFail()->getIdOrFail());

            return $taskCriteriaTransfer->setTasksConditions($taskConditions);
        }

        return $taskCriteriaTransfer
            ->setPagination($glueRequestTransfer->getPagination())
            ->setSortCollection($glueRequestTransfer->getSortings())
            ->setTasksConditions($taskConditions);
    }

    public function getTaskById(
        GlueRequestTransfer $glueRequestTransfer
    ): GlueResponseTransfer {
        $taskResponseTransfer = $this->tasksFacade->getTaskById(
            $glueRequestTransfer->getResource()->getId(),
        );

        return $this->responseMapper->mapTaskResponseTransferToGlueResponseTransfer(
            $taskResponseTransfer,
            $glueRequestTransfer
        );
    }
}
