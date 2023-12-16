<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace BrunoViana\Glue\TasksBackendApi;

use BrunoViana\Glue\TasksBackendApi\Dependency\Facade\TaskBackendApiToTasksFacade;
use Spryker\Glue\Kernel\Backend\AbstractBundleDependencyProvider;
use Spryker\Glue\Kernel\Backend\Container;

class TasksBackendApiDependencyProvider extends AbstractBundleDependencyProvider
{
    public const FACADE_TASKS = 'FACADE_TASKS';

    /**
     * @param \Spryker\Glue\Kernel\Backend\Container $container
     *
     * @return \Spryker\Glue\Kernel\Backend\Container
     */
    public function provideBackendDependencies(Container $container): Container
    {
        $container = parent::provideBackendDependencies($container);
        $container = $this->addTasksFacade($container);

        return $container;
    }

    protected function addTasksFacade(Container $container): Container
    {
        $container->set(static::FACADE_TASKS, function (Container $container) {
            return new TaskBackendApiToTasksFacade(
                $container->getLocator()->tasks()->facade(),
            );
        });

        return $container;
    }
}
