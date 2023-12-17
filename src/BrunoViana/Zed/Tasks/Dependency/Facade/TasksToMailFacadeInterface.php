<?php

namespace BrunoViana\Zed\Tasks\Dependency\Facade;

use Generated\Shared\Transfer\MailTransfer;

interface TasksToMailFacadeInterface
{
    public function handleMail(MailTransfer $mailTransfer);
}
