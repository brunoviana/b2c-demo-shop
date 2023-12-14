<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\TasksRestApi\Processor\RestResponseBuilder;

use Pyz\Glue\TasksRestApi\Processor\Mapper\TaskMapperInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;

class TaskRestResponseBuilder implements TaskRestResponseBuilderInterface
{
    /**
     * @var \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected $restResourceBuilder;

    /**
     * @var \Pyz\Glue\TasksRestApi\Processor\Mapper\TaskMapperInterface
     */
    protected $taskMapper;

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
     * @param \Pyz\Glue\TasksRestApi\Processor\Mapper\TaskMapperInterface $taskMapper
     */
    public function __construct(RestResourceBuilderInterface $restResourceBuilder, TaskMapperInterface $taskMapper)
    {
        $this->restResourceBuilder = $restResourceBuilder;
        $this->taskMapper = $taskMapper;
    }
}
