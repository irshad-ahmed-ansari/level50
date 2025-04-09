<?php

namespace Pyz\Zed\AntelopeLocationDataImport\Business;

use Generated\Shared\Transfer\DataImporterConfigurationTransfer;
use Pyz\Zed\AntelopeLocationDataImport\Business\DataImportStep\AntelopeLocationWriterStep;
use Spryker\Zed\DataImport\Business\DataImportBusinessFactory;

use Spryker\Zed\DataImport\Business\Model\DataImporterInterface;
class AntelopeLocationDataImportBusinessFactory extends DataImportBusinessFactory
{
    /**
     * @param \Generated\Shared\Transfer\DataImporterConfigurationTransfer|null $dataImporterConfigurationTransfer
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface
     */
    public function createAntelopeLocationDataImport(?DataImporterConfigurationTransfer $dataImporterConfigurationTransfer = null): DataImporterInterface
    {
        $dataImporter = $this->getCsvDataImporterFromConfig($dataImporterConfigurationTransfer);

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker();
        $dataSetStepBroker->addStep($this->createAntelopeLocationWriterStep());

        $dataImporter->addDataSetStepBroker($dataSetStepBroker);

        return $dataImporter;
    }

    /**
     * @return \Pyz\Zed\AntelopeLocationDataImport\Business\DataImportStep\AntelopeLocationWriterStep
     */
    public function createAntelopeLocationWriterStep(): AntelopeLocationWriterStep
    {
        return new AntelopeLocationWriterStep();
    }
}
