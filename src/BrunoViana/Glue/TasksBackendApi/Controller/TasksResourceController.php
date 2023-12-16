<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace BrunoViana\Glue\TasksBackendApi\Controller;

use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\GlueResponseTransfer;
use Spryker\Glue\Kernel\Backend\Controller\AbstractController;


/**
 * @method \BrunoViana\Glue\TasksBackendApi\TasksBackendApiFactory getFactory()
 */
class TasksResourceController  extends AbstractController //extends AbstractBackendApiController
{
    public function getAction(GlueRequestTransfer $glueRequestTransfer): GlueResponseTransfer
    {
        return $this->getFactory()->createTaskReader()->getTaskById($glueRequestTransfer);
    }

    // request collection
}
