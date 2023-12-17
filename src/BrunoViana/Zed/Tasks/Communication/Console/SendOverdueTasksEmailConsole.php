<?php

namespace BrunoViana\Zed\Tasks\Communication\Console;

use BrunoViana\Zed\Tasks\Business\TasksFacadeInterface;
use Spryker\Zed\Kernel\Communication\Console\Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method TasksFacadeInterface getFacade()
 */
class SendOverdueTasksEmailConsole extends Console
{
    public const COMMAND_NAME = 'tasks:notify-overdue';
    public const DESCRIPTION = 'Send email notifying overdue tasks';

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->setName(self::COMMAND_NAME);
        $this->setDescription(self::DESCRIPTION);

        parent::configure();
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getFacade()->sendOverdueEmails();

        return static::CODE_SUCCESS;
    }

}
