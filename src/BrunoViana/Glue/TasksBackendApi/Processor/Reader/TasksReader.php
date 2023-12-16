<?php

namespace BrunoViana\Glue\TasksBackendApi\Processor\Reader;

use BrunoViana\Glue\TasksBackendApi\Dependency\Facade\TaskBackendApiToTasksFacadeInterface;
use BrunoViana\Glue\TasksBackendApi\Mapper\GlueResponseTaskMapperInterface;
use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\GlueResponseTransfer;

class TasksReader implements TasksReaderInterface
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

//    public function getTest(RestRequestInterface $restRequest): RestResponseInterface
//    {
//        $transfer = new RestTasksAttributesTransfer();
//        $transfer->setName('Teste');
//
//        $restResource = $this->restResourceBuilder->createRestResource(
//            TasksBackendApiConfig::RESOURCE_TASKS,
//            null,
//            $transfer,
//        );
//
//        return $this->restResourceBuilder
//            ->createRestResponse()
//            ->addResource($restResource);
//    }
}
