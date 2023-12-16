<?php

namespace BrunoViana\Glue\TasksBackendApi\Mapper;

use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\GlueResponseTransfer;
use Generated\Shared\Transfer\TaskResponseTransfer;

interface GlueResponseTaskMapperInterface
{
    public function mapTaskResponseTransferToGlueResponseTransfer(
        TaskResponseTransfer $taskResponseTransfer,
        GlueRequestTransfer $glueRequestTransfer,
    ): GlueResponseTransfer;

    public function mapTaskResponseTransferWithErrorToGlueResponse(
        TaskResponseTransfer $taskResponseTransfer,
        GlueResponseTransfer $glueResponseTransfer,
    ): GlueResponseTransfer;

    public function mapErrorToResponseTransfer(
        GlueResponseTransfer $glueResponseTransfer,
        string $message,
    ): GlueResponseTransfer;

    public function createGlueResponseTransfer(): GlueResponseTransfer;
}
