<?php

namespace BrunoViana\Glue\TasksBackendApi\Mapper;

use Generated\Shared\Transfer\TasksBackendApiAttributesTransfer;
use Generated\Shared\Transfer\TaskTransfer;

class TasksBackendApiAttributesMapper implements TasksBackendApiAttributesMapperInterface
{
    public function mapTaskTransferToTasksBackendApiAttributes(
        TaskTransfer $taskTransfer,
        TasksBackendApiAttributesTransfer $taskBackendApiAttributeTransfer,
    ): TasksBackendApiAttributesTransfer {
        return $taskBackendApiAttributeTransfer->fromArray($taskTransfer->toArray());
    }
}
