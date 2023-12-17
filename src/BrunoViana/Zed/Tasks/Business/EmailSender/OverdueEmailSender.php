<?php

namespace BrunoViana\Zed\Tasks\Business\EmailSender;

use BrunoViana\Zed\Tasks\Communication\Plugin\Mail\OverdueTaskMailTypeBuilderPlugin;
use BrunoViana\Zed\Tasks\Dependency\Facade\TasksToMailFacadeInterface;
use BrunoViana\Zed\Tasks\Dependency\Facade\TasksToUserFacadeInterface;
use BrunoViana\Zed\Tasks\Persistence\TasksRepositoryInterface;
use Generated\Shared\Transfer\MailTransfer;
use Generated\Shared\Transfer\SendOverdueEmailsResponseTransfer;
use Generated\Shared\Transfer\TaskConditionsTransfer;
use Generated\Shared\Transfer\TaskCriteriaTransfer;
use Generated\Shared\Transfer\TaskTransfer;

class OverdueEmailSender implements OverdueEmailSenderInterface
{
    public function __construct(
        protected TasksRepositoryInterface $taskRepository,
        protected TasksToMailFacadeInterface $mailFacade,
        protected TasksToUserFacadeInterface $userFacade,
    ) {}

    public function sendEmailForTasksDueYesterday(): SendOverdueEmailsResponseTransfer
    {
        $taskConditions = new TaskConditionsTransfer();
        $taskConditions->setDueAt(
            date('Y-m-d',strtotime("-1 days"))
        );

        $taskCriteriaTrasnfer = new TaskCriteriaTransfer();
        $taskCriteriaTrasnfer->setTasksConditions($taskConditions);

        $taskCollection = $this->taskRepository->getTaskCollection($taskCriteriaTrasnfer);

        foreach ($taskCollection->getTasks() as $task) {
            $this->handleMail($task);
        }

        return (new SendOverdueEmailsResponseTransfer)->setCount(
            $taskCollection->getTasks()->count()
        );
    }
    protected function handleMail(TaskTransfer $task): void
    {
        $mailTransfer = (new MailTransfer())
            ->setType(OverdueTaskMailTypeBuilderPlugin::MAIL_TYPE)
            ->setUser(
                $this->userFacade->getUserById($task->getIdAssignee())
            )
            ->setTask($task);

        $this->mailFacade->handleMail($mailTransfer);
    }

}
