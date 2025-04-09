<?php

namespace Pyz\Zed\AntelopeLocationDataImport\Business\DataImportStep;

use Orm\Zed\Antelope\Persistence\PyzAntelopeQuery;
use Pyz\Zed\AntelopeLocationDataImport\Business\DataSet\AntelopeLocationDataSetInterface;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;

class AntelopeLocationWriterStep implements DataImportStepInterface
{
    public function execute(DataSetInterface $dataSet): void
    {
        $antelopeLocationEntity = PyzAntelopeLocationQuery::create()
            ->filterByName($dataSet[AntelopeLocationDataSetInterface::COLUMN_NAME])
            ->findOneOrCreate();


        if ($antelopeLocationEntity->isNew() || $antelopeLocationEntity->isModified()) {
            $antelopeLocationEntity->save();
            $this->addPublishEvents(AntelopeLocationSearchConfig::ANTELOPE_LOCATION_PUBLISH, $antelopeLocationEntity->getIdAntelopeLocation());
        }
    }
}
