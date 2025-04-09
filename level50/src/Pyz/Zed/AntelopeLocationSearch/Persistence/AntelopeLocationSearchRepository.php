<?php

namespace Pyz\Zed\AntelopeLocationSearch\Persistence;

use Generated\Shared\Transfer\AntelopeCriteriaTransfer;
use Generated\Shared\Transfer\AntelopeSearchCriteriaTransfer;
use Generated\Shared\Transfer\AntelopeLocationSearchTransfer;
use Generated\Shared\Transfer\AntelopeLocationTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \Pyz\Zed\AntelopeLocationSearch\Persistence\AntelopeLocationSearchPersistenceFactory getFactory()
 */
class AntelopeLocationSearchRepository extends AbstractRepository implements AntelopeSearchRepositoryInterface
{
    /**
     * @param \Generated\Shared\Transfer\AntelopeCriteriaTransfer $antelopeCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\AntelopeTransfer[]
     */
    public function getAntelopeLocations(AntelopeCriteriaTransfer $antelopeCriteriaTransfer): array
    {
        $antelopeLocationEntities = $this->getFactory()
            ->getAntelopeLocationPropelQuery()
            ->filterByIdAntelopeLocation_In($antelopeCriteriaTransfer->getIdsAntelope())
            ->find();

        $antelopeLocationTransfers = [];

        foreach ($antelopeLocationEntities as $antelopeLocationEntity) {
            $antelopeLocationTransfers[] = (new AntelopeLocationTransfer())
                ->fromArray($antelopeLocationEntity->toArray(), true);
        }

        return $antelopeLocationTransfers;
    }

    /**
     * @param \Generated\Shared\Transfer\AntelopeLocationSearchCriteriaTransfer $antelopeLocationSearchCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\AntelopeLocationSearchTransfer[]
     */
    public function getAntelopeLocationSearches(AntelopeLocationSearchCriteriaTransfer $antelopeLocationSearchCriteriaTransfer): array
    {
        $antelopeLocationSearchEntities = $this->getFactory()
            ->createAntelopeLocationSearchQuery()
            ->filterByfkAntelopeLocation_In($antelopeLocationSearchCriteriaTransfer->getFksAntelopeLocation())
            ->find();

        $antelopeLocationSearchTransfers = [];

        foreach ($antelopeLocationSearchEntities as $antelopeLocationSearchEntity) {
            $antelopeLocationSearchTransfers[] = $this->getFactory()
                ->createAntelopeLocationSearchMapper()
                ->mapAntelopeLocationSearchEntityToAntelopeLocationSearchTransfer($antelopeLocationSearchEntity, new AntelopeLocationSearchTransfer());
        }

        return $antelopeLocationSearchTransfers;
    }
}
