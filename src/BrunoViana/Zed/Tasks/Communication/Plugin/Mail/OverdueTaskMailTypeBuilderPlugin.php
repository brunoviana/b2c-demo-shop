<?php

namespace BrunoViana\Zed\Tasks\Communication\Plugin\Mail;

use Generated\Shared\Transfer\MailRecipientTransfer;
use Generated\Shared\Transfer\MailTemplateTransfer;
use Generated\Shared\Transfer\MailTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\MailExtension\Dependency\Plugin\MailTypeBuilderPluginInterface;

class OverdueTaskMailTypeBuilderPlugin extends AbstractPlugin implements MailTypeBuilderPluginInterface
{

    public const MAIL_TYPE = 'overdue task';

    public function getName(): string
    {
        return static::MAIL_TYPE;
    }

    public function build(MailTransfer $mailTransfer): MailTransfer
    {
        $taskTransfer = $mailTransfer->requireTask()->getTask();
        $userTransfer = $mailTransfer->requireUser()->getUser();

        return $mailTransfer
            ->setSubject(
                sprintf('Overdue task "%s"', $taskTransfer->getTitle())
            )
            ->addTemplate(
                (new MailTemplateTransfer())
                    ->setName('tasks/mail/overdue_task.html.twig')
                    ->setIsHtml(true),
            )
            ->addRecipient(
                (new MailRecipientTransfer())
                    ->setEmail($userTransfer->getEmail())
                    ->setName(sprintf('%s %s', $userTransfer->getFirstName(), $userTransfer->getLastName())),
            );
    }
}
