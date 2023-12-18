<?php

namespace BrunoViana\Glue\TasksBackendApi\Processor\Creator;

use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\GlueResponseTransfer;
use Generated\Shared\Transfer\TaskCollectionTransfer;
use Generated\Shared\Transfer\TaskResponseTransfer;
use Symfony\Component\Validator\ConstraintViolationListInterface;

interface GlueResponseCreatorInterface
{
    public function createFromTaskCollectionTransfer(
        TaskCollectionTransfer $taskCollectionTransfer,
        GlueRequestTransfer    $glueRequestTransfer,
    ): GlueResponseTransfer;

    public function createFromTaskResponseTransfer(
        TaskResponseTransfer $taskResponseTransfer,
        GlueRequestTransfer $glueRequestTransfer,
    ): GlueResponseTransfer;

    public function createTaskResponseTransferWithError(
        TaskResponseTransfer $taskResponseTransfer,
        GlueResponseTransfer $glueResponseTransfer,
    ): GlueResponseTransfer;

    public function createWithErrorMessage(
        GlueResponseTransfer $glueResponseTransfer,
        string $message,
    ): GlueResponseTransfer;

    public function createGlueResponseTransfer(): GlueResponseTransfer;

    public function createForbiddenResponse(): GlueResponseTransfer;

    public function createFromValidationErrors(ConstraintViolationListInterface $errors): GlueResponseTransfer;
}
