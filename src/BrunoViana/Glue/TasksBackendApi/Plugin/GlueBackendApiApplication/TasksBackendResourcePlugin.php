<?php

namespace BrunoViana\Glue\TasksBackendApi\Plugin\GlueBackendApiApplication;

use BrunoViana\Glue\TasksBackendApi\Controller\TasksResourceController;
use Generated\Shared\Transfer\GlueResourceMethodCollectionTransfer;
use Generated\Shared\Transfer\GlueResourceMethodConfigurationTransfer;
use Generated\Shared\Transfer\RouteAuthorizationConfigTransfer;
use Generated\Shared\Transfer\TasksBackendApiAttributesTransfer;
use Spryker\Glue\GlueApplication\Plugin\GlueApplication\Backend\AbstractResourcePlugin;
use Spryker\Glue\GlueApplicationAuthorizationConnectorExtension\Dependency\Plugin\AuthorizationStrategyAwareResourceRoutePluginInterface;
use Spryker\Glue\GlueJsonApiConventionExtension\Dependency\Plugin\JsonApiResourceInterface;
use Symfony\Component\HttpFoundation\Request;

class TasksBackendResourcePlugin extends AbstractResourcePlugin implements JsonApiResourceInterface, AuthorizationStrategyAwareResourceRoutePluginInterface
{

    public function getType(): string
    {
        return 'tasks';
    }

    public function getController(): string
    {
        return TasksResourceController::class;
    }

    public function getDeclaredMethods(): GlueResourceMethodCollectionTransfer
    {
        return (new GlueResourceMethodCollectionTransfer())
            ->setGet(
                (new GlueResourceMethodConfigurationTransfer())
                    ->setAction('getAction')
                    ->setAttributes(TasksBackendApiAttributesTransfer::class)
                    ->setIsProtected(true)
                    ->setIsSingularResponse(true)
            )->setGetCollection(
                (new GlueResourceMethodConfigurationTransfer())
                    ->setAction('getCollectionAction')
                    ->setAttributes(TasksBackendApiAttributesTransfer::class),
            )->setPost(
                (new GlueResourceMethodConfigurationTransfer())
                    ->setAction('postAction')
                    ->setAttributes(TasksBackendApiAttributesTransfer::class),
            )->setPatch(
                (new GlueResourceMethodConfigurationTransfer())
                    ->setAction('patchAction')
                    ->setAttributes(TasksBackendApiAttributesTransfer::class),
            )->setDelete(
                (new GlueResourceMethodConfigurationTransfer())
                    ->setAction('deleteAction'),
            );
    }

    public function getRouteAuthorizationConfigurations(): array
    {
        return [
            Request::METHOD_GET => (new RouteAuthorizationConfigTransfer())->addStrategy('ApiKey'),
            Request::METHOD_POST => (new RouteAuthorizationConfigTransfer())->addStrategy('ApiKey'),
            Request::METHOD_PATCH => (new RouteAuthorizationConfigTransfer())->addStrategy('ApiKey'),
            Request::METHOD_DELETE => (new RouteAuthorizationConfigTransfer())->addStrategy('ApiKey'),
        ];
    }
}
