<?php

namespace BrunoViana\Glue\TasksBackendApi\Mapper;

use Generated\Shared\Transfer\GlueErrorTransfer;
use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\GlueResourceTransfer;
use Generated\Shared\Transfer\GlueResponseTransfer;
use Generated\Shared\Transfer\TaskResponseTransfer;
use Generated\Shared\Transfer\TasksBackendApiAttributesTransfer;
use Generated\Shared\Transfer\TaskTransfer;
use Symfony\Component\HttpFoundation\Response;

class GlueResponseTaskMapper implements GlueResponseTaskMapperInterface
{
    protected const RESPONSE_CODE_ENTITY_DOES_NOT_EXIST = 1303;

    protected const HEADER_CONTENT_TYPE = 'Content-Type';

    protected const CONTENT_TYPE_APP_JSON = 'application/json';

    public function __construct(
        protected TasksBackendApiAttributesMapperInterface $tasksBackendApiAttributesMapper,
    ) {}

    public function mapTaskResponseTransferToGlueResponseTransfer(
        TaskResponseTransfer $taskResponseTransfer,
        GlueRequestTransfer $glueRequestTransfer,
    ): GlueResponseTransfer {
        $glueResponseTransfer = $this->createGlueResponseTransfer();

        if ($taskResponseTransfer->getErrors()->count()) {
            foreach ($taskResponseTransfer->getErrors() as $errorTransfer) {
                $glueResponseTransfer = $this->mapErrorToResponseTransfer(
                    $glueResponseTransfer,
                    $errorTransfer->getMessageOrFail(),
                );
            }

            return $glueResponseTransfer;
        }

        $glueResponseTransfer->addResource(
            $this->createTasksBackendApiResource($taskResponseTransfer->getTaskTransfer())
        );

        return $glueResponseTransfer;
    }

    public function mapErrorToResponseTransfer(
        GlueResponseTransfer $glueResponseTransfer,
        string $message,
    ): GlueResponseTransfer {
        $glueResponseTransfer->setHttpStatus(Response::HTTP_NOT_FOUND);

        // @TODO translate error messages
        // @TODO response proper errors and status code for other kind of fails
        $glueResponseTransfer->addError(
            $this->createGlueErrorTransfer($message)
        );

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
            ->setType('tasks') // @TODO use constant
            ->setAttributes($tasksBackendApiAttributesTransfer);
    }

    protected function createGlueResponseTransfer(): GlueResponseTransfer
    {
        $glueResponseTransfer = new GlueResponseTransfer();
        $glueResponseTransfer->setMeta(array_merge($glueResponseTransfer->getMeta(), $this->getResponseHeaders()));

        return $glueResponseTransfer;
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
