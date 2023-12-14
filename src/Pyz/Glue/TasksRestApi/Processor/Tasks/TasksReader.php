<?php

namespace Pyz\Glue\TasksRestApi\Processor\Tasks;

use Pyz\Glue\TasksRestApi\TasksRestApiConfig;
use Generated\Shared\Transfer\RestTasksAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;

class TasksReader implements TasksReaderInterface
{
    public function __construct(
        protected RestResourceBuilderInterface $restResourceBuilder,
    ) {}

    public function getTest(RestRequestInterface $restRequest): RestResponseInterface
    {
        $transfer = new RestTasksAttributesTransfer();
        $transfer->setName('Teste');

        $restResource = $this->restResourceBuilder->createRestResource(
            TasksRestApiConfig::RESOURCE_TASKS,
            null,
            $transfer,
        );

        return $this->restResourceBuilder
            ->createRestResponse()
            ->addResource($restResource);
    }
}
