<?php

namespace BrunoViana\Zed\Tasks\Persistence;

use Generated\Shared\Transfer\PaginationTransfer;
use Generated\Shared\Transfer\TaskCollectionTransfer;
use Generated\Shared\Transfer\TaskConditionsTransfer;
use Generated\Shared\Transfer\TaskCriteriaTransfer;
use Generated\Shared\Transfer\TaskTransfer;
use Orm\Zed\Tasks\Persistence\BvTaskQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \BrunoViana\Zed\Tasks\Persistence\TasksPersistenceFactory getFactory()
 */
class TasksRepository extends AbstractRepository implements TasksRepositoryInterface
{
    public function getTaskById(int $taskId): ?TaskTransfer
    {
        $taskEntity = $this->getFactory()
            ->createTaskQuery()
            ->filterByIdTask($taskId)
            ->findOne();

        if (!$taskEntity) {
            return null;
        }

        return $this->getFactory()
            ->createTaskMapper()
            ->mapTaskEntityToTaskTransfer($taskEntity, new TaskTransfer());
    }

    public function getTaskCollection(
        TaskCriteriaTransfer $taskCriteriaTransfer
    ): TaskCollectionTransfer {
        $taskCollectionTransfer = new TaskCollectionTransfer();

        $taskQuery = $this->getFactory()->createTaskQuery();

        $taskQuery = $this->applyFilters(
            $taskQuery,
            $taskCriteriaTransfer->getTasksConditions(),
        );

        $sortTransferCollection = $taskCriteriaTransfer->getSortCollection();

        $taskQuery = $this->applyTaskSorting(
            $taskQuery,
            $sortTransferCollection,
        );

        $paginationTransfer = $taskCriteriaTransfer->getPagination();
        if ($paginationTransfer !== null) {
            $taskQuery = $this->applyTaskPagination($taskQuery, $paginationTransfer);
            $taskCollectionTransfer->setPagination($paginationTransfer);
        }

        $taskQueryResult = $taskQuery->find();

        if ($taskQueryResult->count() === 0) {
            return $taskCollectionTransfer;
        }

        return $this->getFactory()
            ->createTaskMapper()
            ->mapTaskQueryResultToTaskCollectionTransfer(
                $taskQueryResult,
                $taskCollectionTransfer
            );
    }

    protected function applyTaskPagination(
        BvTaskQuery $taskQuery,
        PaginationTransfer $paginationTransfer
    ): ModelCriteria {
        if ($paginationTransfer->getOffset() !== null || $paginationTransfer->getLimit() !== null) {
            $taskQuery
                ->offset($paginationTransfer->getOffsetOrFail())
                ->setLimit($paginationTransfer->getLimitOrFail());

            return $taskQuery;
        }

        $paginationModel = $taskQuery->paginate(
            $paginationTransfer->getPageOrFail(),
            $paginationTransfer->getMaxPerPageOrFail(),
        );

        $paginationTransfer
            ->setNbResults($paginationModel->getNbResults())
            ->setFirstIndex($paginationModel->getFirstIndex())
            ->setLastIndex($paginationModel->getLastIndex())
            ->setFirstPage($paginationModel->getFirstPage())
            ->setLastPage($paginationModel->getLastPage())
            ->setNextPage($paginationModel->getNextPage())
            ->setPreviousPage($paginationModel->getPreviousPage())
        ;

        return $paginationModel->getQuery();
    }

    protected function applyTaskSorting(
        BvTaskQuery $taskQuery,
        \ArrayObject $sortTransfers
    ): BvTaskQuery {
        foreach ($sortTransfers as $sortTransfer) {
            $taskQuery->orderBy(
                $sortTransfer->getFieldOrFail(),
                $sortTransfer->getIsAscending() ? Criteria::ASC : Criteria::DESC,
            );
        }

        return $taskQuery;
    }

    protected function applyFilters(
        BvTaskQuery $taskQuery,
        ?TaskConditionsTransfer $taskConditionsTransfer,
    ): BvTaskQuery {
        if ($taskConditionsTransfer === null) {
            return $taskQuery;
        }

        if ($taskConditionsTransfer->getTaskIds()) {
            $taskQuery->filterByIdTask_In($taskConditionsTransfer->getTaskIds());
        }

        if ($taskConditionsTransfer->getDueAt()) {
            $taskQuery->filterByDueAt($taskConditionsTransfer->getDueAt());
        }

        return $taskQuery;
    }
}
