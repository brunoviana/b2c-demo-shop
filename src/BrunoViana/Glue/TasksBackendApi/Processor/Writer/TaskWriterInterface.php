<?php

namespace BrunoViana\Glue\TasksBackendApi\Processor\Writer;

use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\GlueResponseTransfer;
use Generated\Shared\Transfer\TasksBackendApiAttributesTransfer;

interface TaskWriterInterface
{
    public function createTask(
        TasksBackendApiAttributesTransfer $taskBackendApiAttributesTransfer,
        GlueRequestTransfer $glueRequestTransfer
    ): GlueResponseTransfer;

    public function updateTask(
        TasksBackendApiAttributesTransfer $taskBackendApiAttributesTransfer,
        GlueRequestTransfer $glueRequestTransfer
    ): GlueResponseTransfer;

    public function deleteTask(
        GlueRequestTransfer $glueRequestTransfer
    ): GlueResponseTransfer;
}
