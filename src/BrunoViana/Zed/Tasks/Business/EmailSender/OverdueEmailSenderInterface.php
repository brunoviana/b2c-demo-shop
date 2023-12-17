<?php

namespace BrunoViana\Zed\Tasks\Business\EmailSender;

use Generated\Shared\Transfer\SendOverdueEmailsResponseTransfer;

interface OverdueEmailSenderInterface
{
    public function sendEmailForTasksDueYesterday(): SendOverdueEmailsResponseTransfer;
}
