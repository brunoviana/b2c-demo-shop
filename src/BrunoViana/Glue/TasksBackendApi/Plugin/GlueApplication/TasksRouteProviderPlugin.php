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
    protected const STRATEGIES_AUTHORIZATION = '_authorization_strategies';

    protected const STRATEGY_AUTHORIZATION_API_KEY = 'ApiKey';

    public const GET_COLLECTION_ROUTE_PATH = '/tasks';

    public const GET_COLLECTION_ACTION = 'getCollectionAction';

    public const GET_ACTION = 'getAction';

    public const GET_ACTION_ROUTE_PATH = '/tasks/{id}';

    public const POST_ACTION_ROUTE_PATH = '/tasks';

    public const POST_ACTION = 'postAction';

    public const PATCH_ACTION_ROUTE_PATH = '/tasks/{id}';

    public const PATCH_ACTION = 'patchAction';

    public const DELETE_ACTION = 'deleteAction';

    public const DELETE_ACTION_ROUTE_PATH = '/tasks/{id}';

    public const METHOD_GET = 'GET';

    public const METHOD_POST = 'POST';

    public const METHOD_PATCH = 'PATCH';

    public const METHOD_DELETE = 'DELETE';

    public const CONTROLLER = '_controller';

    public const METHOD = '_method';

    public const TASKS_ENDPOINT_GET_COLLECTION = 'tasks-endpoint-get-collection';

    public const TASKS_ENDPOINT_GET = 'tasks-endpoint-get';

    public const TASKS_ENDPOINT_POST = 'tasks-endpoint-post';

    public const TASKS_ENDPOINT_PATCH = 'tasks-endpoint-patch';

    public const TASKS_ENDPOINT_DELETE = 'tasks-endpoint-delete';

    public function addRoutes(RouteCollection $routeCollection): RouteCollection
    {
        $route = new Route(self::GET_COLLECTION_ROUTE_PATH);
        $route->setDefault(self::CONTROLLER, [TasksResourceController::class, self::GET_COLLECTION_ACTION])
            ->setDefault(self::METHOD, self::METHOD_GET)
            ->setDefault(static::STRATEGIES_AUTHORIZATION, [static::STRATEGY_AUTHORIZATION_API_KEY])
            ->setMethods(self::METHOD_GET);

        $routeCollection->add(
            self::TASKS_ENDPOINT_GET_COLLECTION,
            $route,
        );

        $route = new Route(self::GET_ACTION_ROUTE_PATH);
        $route->setDefault(self::CONTROLLER, [TasksResourceController::class, self::GET_ACTION])
            ->setDefault(self::METHOD, self::METHOD_GET)
            ->setDefault(static::STRATEGIES_AUTHORIZATION, [static::STRATEGY_AUTHORIZATION_API_KEY])
            ->setMethods(self::METHOD_GET);

        $routeCollection->add(
            self::TASKS_ENDPOINT_GET,
            $route,
        );

        $route = new Route(self::POST_ACTION_ROUTE_PATH);
        $route->setDefault(self::CONTROLLER, [TasksResourceController::class, self::POST_ACTION])
            ->setDefault(self::METHOD, self::METHOD_POST)
            ->setDefault(static::STRATEGIES_AUTHORIZATION, [static::STRATEGY_AUTHORIZATION_API_KEY])
            ->setMethods(self::METHOD_POST);

        $routeCollection->add(
            self::TASKS_ENDPOINT_POST,
            $route,
        );

        $route = new Route(self::PATCH_ACTION_ROUTE_PATH);
        $route->setDefault(self::CONTROLLER, [TasksResourceController::class, self::PATCH_ACTION])
            ->setDefault(self::METHOD, self::METHOD_PATCH)
            ->setDefault(static::STRATEGIES_AUTHORIZATION, [static::STRATEGY_AUTHORIZATION_API_KEY])
            ->setMethods(self::METHOD_PATCH);

        $routeCollection->add(
            self::TASKS_ENDPOINT_PATCH,
            $route,
        );

        $route = new Route(self::DELETE_ACTION_ROUTE_PATH);
        $route->setDefault(self::CONTROLLER, [TasksResourceController::class, self::DELETE_ACTION])
            ->setDefault(self::METHOD, self::METHOD_DELETE)
            ->setDefault(static::STRATEGIES_AUTHORIZATION, [static::STRATEGY_AUTHORIZATION_API_KEY])
            ->setMethods(self::METHOD_DELETE);

        $routeCollection->add(
            self::TASKS_ENDPOINT_DELETE,
            $route,
        );

        return $routeCollection;
    }
}
