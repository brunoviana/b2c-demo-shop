<?php

namespace BrunoViana\Glue\TasksBackendApi\Validator;

use Generated\Shared\Transfer\TasksBackendApiAttributesTransfer;
use Symfony\Component\Validator\ConstraintViolationListInterface;

interface TasksBackendApiAttributesValidatorInterface
{
    public function validateForCreation(TasksBackendApiAttributesTransfer $backendApiAttributesTransfer): ConstraintViolationListInterface;

    public function validateForUpdate(TasksBackendApiAttributesTransfer $backendApiAttributesTransfer): ConstraintViolationListInterface;
}
