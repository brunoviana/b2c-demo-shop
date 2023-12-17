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
        return $taskBackendApiAttributeTransfer->fromArray($taskTransfer->toArray(), true);
    }

    public function mapTasksBackendApiAttributesToTaskTransfer(
        TasksBackendApiAttributesTransfer $taskBackendApiAttributeTransfer,
        TaskTransfer $taskTransfer,
        bool $notUpdateNullValues = false,
    ): TaskTransfer {
        if ($notUpdateNullValues === false) {
            return $taskTransfer->fromArray($taskBackendApiAttributeTransfer->toArray());
        }

        return $taskTransfer->fromArray(
            array_filter($taskBackendApiAttributeTransfer->toArray(), function($value){
                return $value !== null;
            }),
            true
        );
    }
}
