<?php

namespace BrunoViana\Glue\TasksBackendApi\Mapper;

use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\TaskTransfer;

interface GlueRequestTaskMapperInterface
{
    public function mapGlueRequestTransferToTaskTransfer(GlueRequestTransfer $glueRequestTransfer): TaskTransfer;
}
