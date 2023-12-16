<?php

namespace BrunoViana\Glue\TasksBackendApi\Mapper;

use Generated\Shared\Transfer\TasksBackendApiAttributesTransfer;
use Generated\Shared\Transfer\TaskTransfer;

interface TasksBackendApiAttributesMapperInterface
{
    public function mapTaskTransferToTasksBackendApiAttributes(
        TaskTransfer $taskTransfer,
        TasksBackendApiAttributesTransfer $taskBackendApiAttributeTransfer,
    ): TasksBackendApiAttributesTransfer;
}
