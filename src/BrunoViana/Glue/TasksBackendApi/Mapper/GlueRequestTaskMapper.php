<?php

namespace BrunoViana\Glue\TasksBackendApi\Mapper;

use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\TaskTransfer;

class GlueRequestTaskMapper implements GlueRequestTaskMapperInterface
{
    public function __construct(
        protected TasksBackendApiAttributesMapperInterface $tasksBackendApiAttributesMapper,
    ) {}

    public function mapGlueRequestTransferToTaskTransfer(GlueRequestTransfer $glueRequestTransfer): TaskTransfer
    {
        dd($glueRequestTransfer);
    }
}
