<?php

namespace Pyz\Zed\AntelopeLocationSearch\Business\Writer;

use Orm\Zed\Antelope\Persistence\PyzAntelopeQuery;
use Orm\Zed\AntelopeLocationSearch\Persistence\PyzAntelopeLocationSearchQuery;
use Generated\Shared\Transfer\AntelopeCriteriaTransfer;
use Generated\Shared\Transfer\AntelopeSearchCriteriaTransfer;
use Generated\Shared\Transfer\AntelopeSearchTransfer;
use Pyz\Zed\AntelopeLocationSearch\Persistence\AntelopeSearchEntityManagerInterface;
use Pyz\Zed\AntelopeLocationSearch\Persistence\AntelopeSearchRepositoryInterface;
use Spryker\Zed\EventBehavior\Business\EventBehaviorFacadeInterface;


class AntelopeLocationSearchWriter
{
    /**
     * @var \Spryker\Zed\EventBehavior\Business\EventBehaviorFacadeInterface
     */
    protected $eventBehaviorFacade;

    /**
     * @var \Pyz\Zed\AntelopeLocationSearch\Persistence\AntelopeLocationSearchRepositoryInterface
     */
    protected $antelopeLocationSearchRepository;

    /**
     * @var \Pyz\Zed\AntelopeLocationSearch\Persistence\AntelopeLocationSearchEntityManagerInterface
     */
    protected $antelopeLocationSearchEntityManager;

    /**
     * @param \Spryker\Zed\EventBehavior\Business\EventBehaviorFacadeInterface $eventBehaviorFacade
     * @param \Pyz\Zed\AntelopeLocationSearch\Persistence\AntelopeLocationSearchRepositoryInterface $antelopeLocationSearchRepository
     * @param \Pyz\Zed\AntelopeLocationSearch\Persistence\AntelopeLocationSearchEntityManagerInterface $antelopeLocationSearchEntityManager
     */
    public function __construct(
        EventBehaviorFacadeInterface $eventBehaviorFacade
        EventBehaviorFacadeInterface $eventBehaviorFacade,
        AntelopeLocationSearchRepositoryInterface $antelopeLocationSearchRepository,
        AntelopeLocationSearchEntityManagerInterface $antelopeLocationSearchEntityManager
    ) {
        $this->eventBehaviorFacade = $eventBehaviorFacade;
        $this->antelopeLocationSearchRepository = $antelopeLocationSearchRepository;
        $this->antelopeLocationSearchEntityManager = $antelopeLocationSearchEntityManager;
    }

    public function writeCollectionByAntelopeLocationEvents(array $eventTransfers): void
    {
        $antelopeLocationIds = $this->eventBehaviorFacade->getEventTransferIds($eventTransfers);

        $this->writeCollectionByAntelopeLocationIds($antelopeLocationIds);
    }

    protected function writeCollectionByAntelopeLocationIds(array $antelopeLocationIds): void
    {
        if (!$antelopeLocationIds) {
            return;
        }

        // Note: The following code should not be part of the Business Layer because it contains persistence logic.
        // For training purposes we keep this block here to focus on the publish&synchronize process.
        // In an optional exercise you will have the task to move the persistence logic properly into the Persistence Layer.

        foreach ($antelopeLocationIds as $antelopeLocationId) {
            $antelopeLocationEntity = PyzAntelopeQuery::create()
                ->filterByIdAntelopeLocation($antelopeLocationId)
                ->findOne();

            $searchEntity = PyzAntelopeLocationSearchQuery::create()
                ->filterByFkAntelopeLocation($antelopeLocationId)
                ->findOneOrCreate();
            $searchEntity->setFkAntelopeLocation($antelopeLocationId);

            $searchData = $antelopeLocationEntity->toArray();
            $searchEntity->setData($searchData);

            $searchEntity->save();
        }
        $antelopeLocationTransfersIndexed = $this->getAntelopeLocationTransfersIndexed($antelopeLocationIds);
        $antelopeLocationSearchTransfersIndexed = $this->getAntelopeLocationSearchTransfersIndexed(array_keys($antelopeLocationTransfersIndexed));

        foreach ($antelopeLocationTransfersIndexed as $antelopeLocationId => $antelopeLocationTransfer) {
            $searchData = $antelopeLocationTransfer->toArray();

            $antelopeLocationSearchTransfer = $antelopeLocationSearchTransfersIndexed[$antelopeLocationId] ?? new AntelopeLocationSearchTransfer();

            $antelopeLocationSearchTransfer
                ->setFkAntelope($antelopeLocationId)
                ->setData($searchData);

            if ($antelopeLocationSearchTransfer->getIdAntelopeLocationSearch() === null) {
                $this->antelopeLocationSearchEntityManager->createAntelopeLocationSearch($antelopeLocationSearchTransfer);

                continue;
            }

            $this->antelopeLocationSearchEntityManager->updateAntelopeLocationSearch($antelopeLocationSearchTransfer);
        }
    }

    /**
     * @param int[] $antelopeLocationIds
     *
     * @return \Generated\Shared\Transfer\AntelopeTransfer[]
     */
    protected function getAntelopeLocationTransfersIndexed(array $antelopeLocationIds): array
    {
        $antelopeCriteriaTransfer = (new AntelopeCriteriaTransfer())
            ->setIdsAntelopeLocation($antelopeLocationIds);

        $antelopeLocationTransfers = $this->antelopeLocationSearchRepository
            ->getAntelopeLocations($antelopeCriteriaTransfer);

        $antelopeLocationTransfersIndexed = [];
        foreach ($antelopeLocationTransfers as $antelopeLocationTransfer) {
            $antelopeLocationTransfersIndexed[$antelopeLocationTransfer->getIdAntelope()] = $antelopeLocationTransfer;
        }

        return $antelopeLocationTransfersIndexed;
    }

    /**
     * @param int[] $antelopeLocationIds
     *
     * @return \Generated\Shared\Transfer\AntelopeLocationSearchTransfer[]
     */
    protected function getAntelopeLocationSearchTransfersIndexed(array $antelopeLocationIds): array
    {
        $antelopeLocationSearchCriteriaTransfer = (new AntelopeLocationSearchCriteriaTransfer())
            ->setFksAntelopeLocation($antelopeLocationIds);

        $antelopeLocationSearchTransfers = $this->antelopeLocationSearchRepository
            ->getAntelopeLocationSearches($antelopeLocationSearchCriteriaTransfer);

        $antelopeLocationSearchTransfersIndexed = [];
        foreach ($antelopeLocationSearchTransfers as $antelopeLocationSearchTransfer) {
            $antelopeLocationSearchTransfersIndexed[$antelopeLocationSearchTransfer->getFkAntelope()] = $antelopeLocationSearchTransfer;
        }

        return $antelopeLocationSearchTransfersIndexed;
    }
}
