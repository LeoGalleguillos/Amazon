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
            $asin         = $itemArray['ASIN'];
            $productArray = $this->asinTable->selectWhereAsin($asin)->current();

            if (!$productArray) {
                if ($this->conditionallySkipItemArrayService->shouldArrayBeSkipped($itemArray)) {
                    continue;
                } else {
                    $this->productTable->insertAsin($asin);
                }
            }

            $this->asinTable->updateSetModifiedToUtcTimestampWhereAsin($asin);

            $this->saveItemArrayToMySqlService->saveArrayToMySql(
                $itemArray
            );
        }
    }
}
