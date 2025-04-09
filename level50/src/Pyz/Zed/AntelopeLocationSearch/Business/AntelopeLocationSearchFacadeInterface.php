<?php

namespace Pyz\Zed\AntelopeLocationSearch\Business;

interface AntelopeLocationSearchFacadeInterface
{
    /**
     * Specification:
     * - Retrieves all antelopes using IDs from $eventTransfers.
     * - Updates entities from `pyz_antelope_location_search` with actual data from obtained antelopes.
     * - Sends a copy of data to queue based on module config.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\EventEntityTransfer[] $eventTransfers
     *
     * @return void
     */
    public function writeCollectionByAntelopeLocationEvents(array $eventTransfers): void;
}
