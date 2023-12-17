<?php

namespace BrunoViana\Zed\Tasks;

use BrunoViana\Zed\Tasks\Dependency\Facade\TasksToMailFacadeBridge;
use BrunoViana\Zed\Tasks\Dependency\Facade\TasksToUserFacadeBridge;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

/**
 * @method \BrunoViana\Zed\Tasks\TasksConfig getConfig()
 */
class TasksDependencyProvider extends AbstractBundleDependencyProvider
{
    public const FACADE_MAIL = 'FACADE_MAIL';

    public const USER_MAIL = 'USER_MAIL';

    public function provideBusinessLayerDependencies(Container $container)
    {
        $container = parent::provideBusinessLayerDependencies($container);
        $container = $this->addMailFacade($container);
        $container = $this->addUserFacade($container);

        return $container;
    }

    protected function addMailFacade(Container $container): Container
    {
        $container->set(static::FACADE_MAIL, function (Container $container) {
            return new TasksToMailFacadeBridge(
                $container->getLocator()->mail()->facade(),
            );
        });

        return $container;
    }

    protected function addUserFacade(Container $container): Container
    {
        $container->set(static::USER_MAIL, function (Container $container) {
            return new TasksToUserFacadeBridge(
                $container->getLocator()->user()->facade(),
            );
        });

        return $container;
    }
}
