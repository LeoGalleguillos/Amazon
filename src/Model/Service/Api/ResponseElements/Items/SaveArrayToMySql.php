<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\ResponseElements\Items;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class SaveArrayToMySql
{
    public function __construct(
        AmazonService\Api\ResponseElements\Items\Item\ConditionallySkipArray $conditionallySkipItemArrayService,
        AmazonService\Api\ResponseElements\Items\Item\SaveArrayToMySql $saveItemArrayToMySqlService,
        AmazonTable\Product $productTable,
        AmazonTable\Product\Asin $asinTable
    ) {
        $this->conditionallySkipItemArrayService = $conditionallySkipItemArrayService;
        $this->saveItemArrayToMySqlService       = $saveItemArrayToMySqlService;
        $this->productTable                      = $productTable;
        $this->asinTable                         = $asinTable;
    }

    public function saveArrayToMySql(
        array $itemsArray
    ) {
        foreach ($itemsArray as $itemArray) {
            if ($this->conditionallySkipItemArrayService->shouldArrayBeSkipped($itemArray)) {
                continue;
            }

            $asin = $itemArray['ASIN'];

            if (count($this->asinTable->selectWhereAsin($asin))) {
                $this->asinTable->updateSetIsValidWhereAsin(1, $asin);
            } else {
                $this->productTable->insertAsin($asin);
            }

            $this->saveItemArrayToMySqlService->saveArrayToMySql(
                $itemArray
            );
        }
    }
}
