<?php

namespace Pyz\Zed\AntelopeLocationSearch\Persistence\Propel\AntelopeSearch\Mapper;

use Generated\Shared\Transfer\AntelopeLocationSearchTransfer;
use Orm\Zed\AntelopeLocationSearch\Persistence\PyzAntelopeLocationSearch;

class AntelopeLocationSearchMapper
{
    /**
     * @param \Generated\Shared\Transfer\AntelopeLocationSearchTransfer $antelopeLocationSearchTransfer
     * @param \Orm\Zed\AntelopeSLocationearch\Persistence\PyzAntelopeLocationSearch $antelopeLocationSearchEntity
     *
     * @return \Orm\Zed\AntelopeLocationSearch\Persistence\PyzAntelopeSearch
     */
    public function mapAntelopeLocationSearchTransferToAntelopeSearchEntity(
        AntelopeLocationSearchTransfer $antelopeLocationSearchTransfer,
        PyzAntelopeLocationSearch $antelopeLocationSearchEntity
    ): PyzAntelopeLocationSearch {
        return $antelopeLocationSearchEntity->fromArray($antelopeLocationSearchTransfer->modifiedToArray());
    }

    /**
     * @param \Orm\Zed\AntelopeSearch\Persistence\PyzAntelopeSearch $antelopeSearchEntity
     * @param \Generated\Shared\Transfer\AntelopeLocationSearchTransfer $antelopeLocationSearchTransfer
     *
     * @return \Generated\Shared\Transfer\AntelopeLocationSearchTransfer
     */
    public function mapAntelopeLocationSearchEntityToAntelopeSearchTransfer(
        PyzAntelopeLocationSearch $antelopeLocationSearchEntity,
        AntelopeLocationSearchTransfer $antelopeLocationSearchTransfer
    ): AntelopeLocationSearchTransfer {
        return $antelopeLocationSearchTransfer->fromArray($antelopeLocationSearchEntity->toArray(), true);
    }
}
