<?php

namespace BrunoViana\Glue\TasksBackendApi\Mapper;

use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\GlueResponseTransfer;
use Generated\Shared\Transfer\TaskCollectionTransfer;
use Generated\Shared\Transfer\TaskResponseTransfer;
use Symfony\Component\Validator\ConstraintViolationListInterface;

interface GlueResponseTaskMapperInterface
{
    public function mapTaskResponseCollectionToGlueResponseTransfer(
        TaskCollectionTransfer $taskCollectionTransfer,
        GlueRequestTransfer    $glueRequestTransfer,
    ): GlueResponseTransfer;

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

    public function createForbiddenResponse(): GlueResponseTransfer;

    public function mapValidationErrorsToGlueResponse(ConstraintViolationListInterface $errors): GlueResponseTransfer;
}
