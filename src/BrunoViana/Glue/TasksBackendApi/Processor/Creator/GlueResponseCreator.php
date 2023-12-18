<?php

namespace BrunoViana\Glue\TasksBackendApi\Processor\Creator;

use BrunoViana\Glue\TasksBackendApi\Mapper\TasksBackendApiAttributesMapperInterface;
use Generated\Shared\Transfer\GlueErrorTransfer;
use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\GlueResourceTransfer;
use Generated\Shared\Transfer\GlueResponseTransfer;
use Generated\Shared\Transfer\TaskCollectionTransfer;
use Generated\Shared\Transfer\TaskResponseTransfer;
use Generated\Shared\Transfer\TasksBackendApiAttributesTransfer;
use Generated\Shared\Transfer\TaskTransfer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class GlueResponseCreator implements GlueResponseCreatorInterface
{
    protected const RESPONSE_CODE_ENTITY_DOES_NOT_EXIST = 1303;

    protected const HEADER_CONTENT_TYPE = 'Content-Type';

    protected const CONTENT_TYPE_APP_JSON = 'application/json';
    public const TYPE_TASKS = 'tasks';

    public function __construct(
        protected TasksBackendApiAttributesMapperInterface $tasksBackendApiAttributesMapper,
    ) {}

    public function createFromTaskCollectionTransfer(
        TaskCollectionTransfer $taskCollectionTransfer,
        GlueRequestTransfer    $glueRequestTransfer,
    ): GlueResponseTransfer {
        $glueResponseTransfer = $this->createGlueResponseTransfer();

        foreach ($taskCollectionTransfer->getTasks() as $taskTransfer) {
            $glueResponseTransfer->addResource(
                $this->createTasksBackendApiResource($taskTransfer),
            );
        }

        if ($taskCollectionTransfer->getPagination()) {
            $glueResponseTransfer->setPagination(
                $taskCollectionTransfer->getPagination()
            );
        }

        return $glueResponseTransfer;
    }

    public function createFromTaskResponseTransfer(
        TaskResponseTransfer $taskResponseTransfer,
        GlueRequestTransfer $glueRequestTransfer,
    ): GlueResponseTransfer {
        $glueResponseTransfer = $this->createGlueResponseTransfer();

        if ($taskResponseTransfer->getErrors()->count()) {
            return $this->createTaskResponseTransferWithError(
                $taskResponseTransfer,
                $glueResponseTransfer
            );
        }

        if ($taskResponseTransfer->getTaskTransfer()) {
            $glueResponseTransfer->addResource(
                $this->createTasksBackendApiResource($taskResponseTransfer->getTaskTransfer())
            );
        }

        return $glueResponseTransfer;
    }

    public function createTaskResponseTransferWithError(
        TaskResponseTransfer $taskResponseTransfer,
        GlueResponseTransfer $glueResponseTransfer,
    ): GlueResponseTransfer {
        foreach ($taskResponseTransfer->getErrors() as $errorTransfer) {
            $glueResponseTransfer = $this->createWithErrorMessage(
                $glueResponseTransfer,
                $errorTransfer->getMessageOrFail(),
            );
        }

        return $glueResponseTransfer;
    }

    public function createWithErrorMessage(
        GlueResponseTransfer $glueResponseTransfer,
        string $message,
    ): GlueResponseTransfer {
        $glueResponseTransfer->setHttpStatus(Response::HTTP_NOT_FOUND);
        $glueResponseTransfer->addError(
            $this->createGlueErrorTransfer($message)
        );

        return $glueResponseTransfer;
    }

    public function createGlueResponseTransfer(): GlueResponseTransfer
    {
        $glueResponseTransfer = new GlueResponseTransfer();
        $glueResponseTransfer->setMeta(array_merge($glueResponseTransfer->getMeta(), $this->getResponseHeaders()));

        return $glueResponseTransfer;
    }

    public function createForbiddenResponse(): GlueResponseTransfer
    {
        return (new GlueResponseTransfer())
            ->setHttpStatus(Response::HTTP_FORBIDDEN)
            ->addError((new GlueErrorTransfer())
                ->setMessage('Operation forbidden')
                ->setStatus(Response::HTTP_FORBIDDEN)
                ->setCode('5204')
            );
    }

    public function createFromValidationErrors(ConstraintViolationListInterface $errors): GlueResponseTransfer
    {
        $glueResponseTransfer = (new GlueResponseTransfer())
            ->setHttpStatus(Response::HTTP_BAD_REQUEST);

        foreach ($errors as $error) {
            $glueResponseTransfer->addError(
                (new GlueErrorTransfer())->setMessage(
                    sprintf('%s: %s', $error->getPropertyPath(), $error->getMessage())
                )
            );
        }

        return $glueResponseTransfer;
    }

    protected function createTasksBackendApiResource(
        TaskTransfer $taskTransfer,
    ): GlueResourceTransfer {
        $tasksBackendApiAttributesTransfer = $this->tasksBackendApiAttributesMapper->mapTaskTransferToTasksBackendApiAttributes(
            $taskTransfer,
            new TasksBackendApiAttributesTransfer()
        );

        return (new GlueResourceTransfer())
            ->setId($taskTransfer->getIdTask())
            ->setType(self::TYPE_TASKS)
            ->setAttributes($tasksBackendApiAttributesTransfer);
    }

    protected function createGlueErrorTransfer(string $message): GlueErrorTransfer
    {
        return (new GlueErrorTransfer())
            ->setStatus(Response::HTTP_NOT_FOUND)
            ->setCode(static::RESPONSE_CODE_ENTITY_DOES_NOT_EXIST)
            ->setMessage($message);
    }

    protected function getResponseHeaders(): array
    {
        return [
            static::HEADER_CONTENT_TYPE => static::CONTENT_TYPE_APP_JSON,
        ];
    }

}
