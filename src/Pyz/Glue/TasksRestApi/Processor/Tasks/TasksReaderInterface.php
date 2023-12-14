<?php

namespace Pyz\Glue\TasksRestApi\Processor\Tasks;

use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

interface TasksReaderInterface
{
    public function getTest(RestRequestInterface $restRequest): RestResponseInterface;
}
