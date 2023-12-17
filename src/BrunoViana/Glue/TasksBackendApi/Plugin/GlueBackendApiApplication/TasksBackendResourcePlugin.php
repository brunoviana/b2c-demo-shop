<?php

namespace BrunoViana\Glue\TasksBackendApi\Plugin\GlueBackendApiApplication;

use BrunoViana\Glue\TasksBackendApi\Controller\TasksResourceController;
use Generated\Shared\Transfer\GlueResourceMethodCollectionTransfer;
use Generated\Shared\Transfer\GlueResourceMethodConfigurationTransfer;
use Generated\Shared\Transfer\TasksBackendApiAttributesTransfer;
use Spryker\Glue\GlueApplication\Plugin\GlueApplication\Backend\AbstractResourcePlugin;
use Spryker\Glue\GlueJsonApiConventionExtension\Dependency\Plugin\JsonApiResourceInterface;

class TasksBackendResourcePlugin extends AbstractResourcePlugin implements JsonApiResourceInterface
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
}
