<?php

namespace BrunoViana\Glue\TasksBackendApi\Processor\Reader;

use BrunoViana\Glue\TasksBackendApi\Dependency\Facade\TaskBackendApiToTasksFacadeInterface;
use BrunoViana\Glue\TasksBackendApi\Mapper\GlueResponseTaskMapperInterface;
use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\GlueResponseTransfer;

class TaskReader implements TaskReaderInterface
{
    public function __construct(
        protected TaskBackendApiToTasksFacadeInterface $tasksFacade,
        protected GlueResponseTaskMapperInterface $responseMapper,
    ) {}

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
