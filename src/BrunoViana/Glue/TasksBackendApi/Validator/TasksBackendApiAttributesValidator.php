<?php

namespace BrunoViana\Glue\TasksBackendApi\Validator;

use BrunoViana\Shared\Tasks\Transfer\TasksConstants;
use Generated\Shared\Transfer\TasksBackendApiAttributesTransfer;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Optional;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TasksBackendApiAttributesValidator implements TasksBackendApiAttributesValidatorInterface
{
    public function __construct(
        protected ValidatorInterface $validator
    ){ }

    public function validateForCreation(TasksBackendApiAttributesTransfer $backendApiAttributesTransfer): ConstraintViolationListInterface
    {
        $constraint = new Collection(
            $this->getQueryValidationsForCreation()
        );

        return $this->validator->validate($backendApiAttributesTransfer->toArray(), $constraint);
    }

    public function validateForUpdate(TasksBackendApiAttributesTransfer $backendApiAttributesTransfer): ConstraintViolationListInterface
    {
        $constraint = new Collection(
            $this->getQueryValidationsForUpdate()
        );

        return $this->validator->validate($backendApiAttributesTransfer->toArray(), $constraint);
    }

    /**
     * @return array
     */
    protected function getQueryValidationsForUpdate(): array
    {
        return [
            'id_task' => [
                new Optional(),
            ],
            'title' => [
                new Optional([
                    new Length(['max' => 45]),
                ]),
            ],
            'description' => [
                new Optional(),
            ],
            'status' => [
                new Optional([
                    new Choice([
                        TasksConstants::STATUS_TODO,
                        TasksConstants::STATUS_IN_PROGRESS,
                        TasksConstants::STATUS_COMPLETED
                    ])
                ]),
            ],
            'due_at' => [
                new Optional([
                    new Date()
                ]),
            ],
        ];
    }

    protected function getQueryValidationsForCreation(): array
    {
        return [
            'id_task' => [
                new Optional(),
            ],
            'title' => [
                new NotBlank(),
                new Length(['max' => 45]),
            ],
            'description' => [
                new Optional(),
            ],
            'status' => [
                new NotBlank(),
                new Choice([
                    TasksConstants::STATUS_TODO,
                    TasksConstants::STATUS_IN_PROGRESS,
                    TasksConstants::STATUS_COMPLETED
                ]),
            ],
            'due_at' => [
                new Optional([
                    new Date()
                ]),
            ],
        ];
    }
}
