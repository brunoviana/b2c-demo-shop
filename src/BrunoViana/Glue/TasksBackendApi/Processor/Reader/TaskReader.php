<?php

namespace BrunoViana\Glue\TasksBackendApi\Processor\Reader;

use BrunoViana\Glue\TasksBackendApi\Dependency\Facade\TaskBackendApiToTasksFacadeInterface;
use BrunoViana\Glue\TasksBackendApi\Processor\Creator\GlueResponseCreatorInterface;
use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\GlueResponseTransfer;
use Generated\Shared\Transfer\TaskConditionsTransfer;
use Generated\Shared\Transfer\TaskCriteriaTransfer;

class TaskReader implements TaskReaderInterface
{
    public function __construct(
        protected TaskBackendApiToTasksFacadeInterface $tasksFacade,
        protected GlueResponseCreatorInterface         $responseCreator,
    ) {}

    public function getTaskCollection(
        GlueRequestTransfer $glueRequestTransfer
    ): GlueResponseTransfer {
        if (!$this->isRequestUserProvided($glueRequestTransfer)) {
            return $this->responseCreator->createForbiddenResponse();
        }

        $taskCriteriaTransfer = $this->createTaskCriteriaTransfer($glueRequestTransfer);
        $tasksCollectionTransfer = $this->tasksFacade->getTaskCollection($taskCriteriaTransfer);

        return $this->responseCreator->createFromTaskCollectionTransfer(
            $tasksCollectionTransfer,
            $glueRequestTransfer
        );
    }

    public function getTaskById(
        GlueRequestTransfer $glueRequestTransfer
    ): GlueResponseTransfer {
        if (!$this->isRequestUserProvided($glueRequestTransfer)) {
            return $this->responseCreator->createForbiddenResponse();
        }

        $glueRequestTransfer->getResource()->requireId();

        $taskResponseTransfer = $this->tasksFacade->getTaskById(
            $glueRequestTransfer->getResource()->getId(),
        );

        return $this->responseCreator->createFromTaskResponseTransfer(
            $taskResponseTransfer,
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

    protected function isRequestUserProvided(GlueRequestTransfer $glueRequestTransfer): bool
    {
        return $glueRequestTransfer->getRequestUser() && $glueRequestTransfer->getRequestUserOrFail()->getSurrogateIdentifier();
    }
}
