<?php

namespace BrunoViana\Zed\Tasks\Dependency\Facade;

use Generated\Shared\Transfer\MailTransfer;
use Spryker\Zed\Mail\Business\MailFacadeInterface;

class TasksToMailFacadeBridge
{
    public function __construct(
        protected MailFacadeInterface $mailFacade,
    ) {}

    public function handleMail(MailTransfer $mailTransfer)
    {
        $this->mailFacade->handleMail($mailTransfer);
    }
}
