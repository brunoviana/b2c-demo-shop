<?php

namespace BrunoViana\Glue\TasksBackendApi\Processor\Reader;

use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\GlueResponseTransfer;

interface TasksReaderInterface
{
    public function getTaskById(GlueRequestTransfer $glueRequestTransfer): GlueResponseTransfer;
}
