<?php

namespace BrunoViana\Zed\Tasks\Persistence\Mapper;

use Generated\Shared\Transfer\TaskCollectionTransfer;
use Generated\Shared\Transfer\TaskTransfer;
use Orm\Zed\Tasks\Persistence\BvTask;
use Propel\Runtime\Collection\ObjectCollection;

interface TaskMapperInterface
{
    public function mapTaskTransferToTaskEntity(TaskTransfer $taskTransfer, BvTask $BvTask): BvTask;

    public function mapTaskEntityToTaskTransfer(BvTask $BvTask, TaskTransfer $taskTransfer): TaskTransfer;

    public function mapTaskQueryResultToTaskCollectionTransfer(
        ObjectCollection $taskQueryResult,
        TaskCollectionTransfer $taskCollectionTransfer,
    ): TaskCollectionTransfer;
}
