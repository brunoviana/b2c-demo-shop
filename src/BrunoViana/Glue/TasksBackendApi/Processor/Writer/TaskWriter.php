<?php

namespace BrunoViana\Glue\TasksBackendApi\Processor\Writer;

use BrunoViana\Glue\TasksBackendApi\Dependency\Facade\TaskBackendApiToTasksFacadeInterface;
use BrunoViana\Glue\TasksBackendApi\Mapper\TasksBackendApiAttributesMapperInterface;
use BrunoViana\Glue\TasksBackendApi\Processor\Creator\GlueResponseCreatorInterface;
use BrunoViana\Glue\TasksBackendApi\Validator\TasksBackendApiAttributesValidatorInterface;
use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\GlueResponseTransfer;
use Generated\Shared\Transfer\TasksBackendApiAttributesTransfer;
use Generated\Shared\Transfer\TaskTransfer;

class TaskWriter implements TaskWriterInterface
{
    public function __construct(
        protected TaskBackendApiToTasksFacadeInterface        $tasksFacade,
        protected TasksBackendApiAttributesMapperInterface    $taskBackendApiAttributesMapper,
        protected GlueResponseCreatorInterface                $responseCreator,
        protected TasksBackendApiAttributesValidatorInterface $validator,
    ) {}

    public function createTask(
        TasksBackendApiAttributesTransfer $taskBackendApiAttributesTransfer,
        GlueRequestTransfer $glueRequestTransfer
    ): GlueResponseTransfer {
        if (!$this->isRequestUserProvided($glueRequestTransfer)) {
            return $this->responseCreator->createForbiddenResponse();
        }

        $errors = $this->validator->validateForCreation($taskBackendApiAttributesTransfer);
        if ($errors->count()) {
            return $this->responseCreator->createFromValidationErrors($errors);
        }

        $taskTransfer = $this->taskBackendApiAttributesMapper->mapTasksBackendApiAttributesToTaskTransfer(
            $taskBackendApiAttributesTransfer,
            new TaskTransfer(),
        );

        $taskTransfer->setIdAssignee(
            $glueRequestTransfer->getRequestUserOrFail()->getSurrogateIdentifier()
        );

        $taskResponseTransfer = $this->tasksFacade->createTask($taskTransfer);

        return $this->responseCreator->createFromTaskResponseTransfer(
            $taskResponseTransfer,
            $glueRequestTransfer
        );
    }

    public function updateTask(
        TasksBackendApiAttributesTransfer $taskBackendApiAttributesTransfer,
        GlueRequestTransfer $glueRequestTransfer
    ): GlueResponseTransfer {
        if (!$this->isRequestUserProvided($glueRequestTransfer)) {
            return $this->responseCreator->createForbiddenResponse();
        }

        $errors = $this->validator->validateForUpdate($taskBackendApiAttributesTransfer);
        if ($errors->count()) {
            return $this->responseCreator->createFromValidationErrors($errors);
        }

        $getTaskByIdResponse = $this->tasksFacade->getTaskById(
            $glueRequestTransfer->getResource()->getId(),
        );

        if ($getTaskByIdResponse->getErrors()->count()) {
            return $this->responseCreator->createTaskResponseTransferWithError(
                $getTaskByIdResponse,
                $this->responseCreator->createGlueResponseTransfer(),
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

        return $this->responseCreator->createFromTaskResponseTransfer(
            $taskResponseTransfer,
            $glueRequestTransfer
        );
    }

    public function deleteTask(
        GlueRequestTransfer $glueRequestTransfer
    ): GlueResponseTransfer {
        if (!$this->isRequestUserProvided($glueRequestTransfer)) {
            return $this->responseCreator->createForbiddenResponse();
        }

        $getTaskByIdResponse = $this->tasksFacade->getTaskById(
            $glueRequestTransfer->getResource()->getId(),
        );

        if ($getTaskByIdResponse->getErrors()->count()) {
            return $this->responseCreator->createTaskResponseTransferWithError(
                $getTaskByIdResponse,
                $this->responseCreator->createGlueResponseTransfer(),
            );
        }

        $taskResponseTransfer = $this->tasksFacade->deleteTask(
            $getTaskByIdResponse->getTaskTransfer()
        );

        return $this->responseCreator->createFromTaskResponseTransfer(
            $taskResponseTransfer,
            $glueRequestTransfer
        );
    }

    protected function isRequestUserProvided(GlueRequestTransfer $glueRequestTransfer): bool
    {
        return $glueRequestTransfer->getRequestUser() && $glueRequestTransfer->getRequestUserOrFail()->getSurrogateIdentifier();
    }
}
