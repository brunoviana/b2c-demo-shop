<?php

namespace BrunoViana\Glue\TasksBackendApi\Processor\Writer;

use BrunoViana\Glue\TasksBackendApi\Dependency\Facade\TaskBackendApiToTasksFacadeInterface;
use BrunoViana\Glue\TasksBackendApi\Mapper\GlueRequestTaskMapperInterface;
use BrunoViana\Glue\TasksBackendApi\Mapper\GlueResponseTaskMapperInterface;
use BrunoViana\Glue\TasksBackendApi\Mapper\TasksBackendApiAttributesMapperInterface;
use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\GlueResponseTransfer;
use Generated\Shared\Transfer\TasksBackendApiAttributesTransfer;
use Generated\Shared\Transfer\TaskTransfer;

class TaskWriter implements TaskWriterInterface
{
    public function __construct(
        protected TaskBackendApiToTasksFacadeInterface $tasksFacade,
        protected TasksBackendApiAttributesMapperInterface $taskBackendApiAttributesMapper,
        protected GlueResponseTaskMapperInterface $responseMapper,
    ) {}

    public function createTask(
        TasksBackendApiAttributesTransfer $taskBackendApiAttributesTransfer,
        GlueRequestTransfer $glueRequestTransfer
    ): GlueResponseTransfer {
        if (!$this->isRequestUserProvided($glueRequestTransfer)) {
            return $this->responseMapper->createForbiddenResponse();
        }

        $taskResponseTransfer = $this->tasksFacade->createTask(
            $this->taskBackendApiAttributesMapper->mapTasksBackendApiAttributesToTaskTransfer(
                $taskBackendApiAttributesTransfer,
                new TaskTransfer(),
            )
        );

        return $this->responseMapper->mapTaskResponseTransferToGlueResponseTransfer(
            $taskResponseTransfer,
            $glueRequestTransfer
        );
    }

    public function updateTask(
        TasksBackendApiAttributesTransfer $taskBackendApiAttributesTransfer,
        GlueRequestTransfer $glueRequestTransfer
    ): GlueResponseTransfer {
        if (!$this->isRequestUserProvided($glueRequestTransfer)) {
            return $this->responseMapper->createForbiddenResponse();
        }

        $getTaskByIdResponse = $this->tasksFacade->getTaskById(
            $glueRequestTransfer->getResource()->getId(),
        );

        if ($getTaskByIdResponse->getErrors()->count()) {
            return $this->responseMapper->mapTaskResponseTransferWithErrorToGlueResponse(
                $getTaskByIdResponse,
                $this->responseMapper->createGlueResponseTransfer(),
            );
        }

        $taskTransfer = $this->taskBackendApiAttributesMapper->mapTasksBackendApiAttributesToTaskTransfer(
            $taskBackendApiAttributesTransfer,
            $getTaskByIdResponse->getTaskTransfer(),
            true
        );


        $taskResponseTransfer = $this->tasksFacade->updateTask(
            $taskTransfer
        );

        return $this->responseMapper->mapTaskResponseTransferToGlueResponseTransfer(
            $taskResponseTransfer,
            $glueRequestTransfer
        );
    }

    public function deleteTask(
        GlueRequestTransfer $glueRequestTransfer
    ): GlueResponseTransfer {
        if (!$this->isRequestUserProvided($glueRequestTransfer)) {
            return $this->responseMapper->createForbiddenResponse();
        }

        $getTaskByIdResponse = $this->tasksFacade->getTaskById(
            $glueRequestTransfer->getResource()->getId(),
        );

        if ($getTaskByIdResponse->getErrors()->count()) {
            return $this->responseMapper->mapTaskResponseTransferWithErrorToGlueResponse(
                $getTaskByIdResponse,
                $this->responseMapper->createGlueResponseTransfer(),
            );
        }

        $taskResponseTransfer = $this->tasksFacade->deleteTask(
            $getTaskByIdResponse->getTaskTransfer()
        );

        return $this->responseMapper->mapTaskResponseTransferToGlueResponseTransfer(
            $taskResponseTransfer,
            $glueRequestTransfer
        );
    }

    protected function isRequestUserProvided(GlueRequestTransfer $glueRequestTransfer): bool
    {
        return $glueRequestTransfer->getRequestUser() && $glueRequestTransfer->getRequestUserOrFail()->getSurrogateIdentifier();
    }
}
