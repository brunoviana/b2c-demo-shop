<?php

namespace BrunoViana\Glue\TasksBackendApi\Processor\Reader;

use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\GlueResponseTransfer;

interface TaskReaderInterface
{
    public function getTaskCollection(
        GlueRequestTransfer $glueRequestTransfer
    ): GlueResponseTransfer;

    public function getTaskById(GlueRequestTransfer $glueRequestTransfer): GlueResponseTransfer;

}
