<?php

namespace BrunoViana\Glue\TasksBackendApi\Plugin\GlueApplication;

use BrunoViana\Glue\TasksBackendApi\Controller\TasksResourceController;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\RouteProviderPluginInterface;
use Spryker\Glue\Kernel\Backend\AbstractPlugin;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class TasksRouteProviderPlugin extends AbstractPlugin implements RouteProviderPluginInterface
{
    /**
     * @var string
     */
    protected const METHOD_GET = 'GET';

    /**
     * @var string
     */
    protected const ROUTE_STORES_GET_LIST = 'tasks';

    /**
     * @var string
     */
    protected const ROUTE_STORES_GET_LIST_ACTION = 'getCollectionAction';

    /**
     * @var string
     */
    protected const STRATEGIES_AUTHORIZATION = '_authorization_strategies';

    /**
     * @var string
     */
    protected const STRATEGY_AUTHORIZATION_API_KEY = 'ApiKey';

    public function addRoutes(RouteCollection $routeCollection): RouteCollection
    {
        // @TODO move to own class

        $route = new Route('/tasks/{id}');
        $route->setDefault('_controller', [TasksResourceController::class, 'getAction'])
            ->setDefault('_method', 'GET')
            ->setDefault(static::STRATEGIES_AUTHORIZATION, [static::STRATEGY_AUTHORIZATION_API_KEY])
            ->setMethods('GET');

        $routeCollection->add(
            'tasks-endpoint-get',
            $route,
        );

        $route = new Route('/tasks');
        $route->setDefault('_controller', [TasksResourceController::class, 'postAction'])
            ->setDefault('_method', 'POST')
            ->setDefault(static::STRATEGIES_AUTHORIZATION, [static::STRATEGY_AUTHORIZATION_API_KEY])
            ->setMethods('POST');

        $routeCollection->add(
            'tasks-endpoint-post',
            $route,
        );

        $route = new Route('/tasks/{id}');
        $route->setDefault('_controller', [TasksResourceController::class, 'patchAction'])
            ->setDefault('_method', 'PATCH')
            ->setDefault(static::STRATEGIES_AUTHORIZATION, [static::STRATEGY_AUTHORIZATION_API_KEY])
            ->setMethods('PATCH');

        $routeCollection->add(
            'tasks-endpoint-patch',
            $route,
        );

        $route = new Route('/tasks/{id}');
        $route->setDefault('_controller', [TasksResourceController::class, 'deleteAction'])
            ->setDefault('_method', 'DELETE')
            ->setDefault(static::STRATEGIES_AUTHORIZATION, [static::STRATEGY_AUTHORIZATION_API_KEY])
            ->setMethods('DELETE');

        $routeCollection->add(
            'tasks-endpoint-delete',
            $route,
        );

        return $routeCollection;
    }
}
