<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\ResponseElements\Items;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class SaveArrayToMySql
{
    public function __construct(
        AmazonService\Api\ResponseElements\Items\Item\SaveArrayToMySql $saveItemArrayToMySqlService,
        AmazonService\Product\Banned $bannedService,
        AmazonTable\Product $productTable,
        AmazonTable\Product\Asin $asinTable
    ) {
        $this->saveItemArrayToMySqlService = $saveItemArrayToMySqlService;
        $this->bannedService               = $bannedService;
        $this->productTable                = $productTable;
        $this->asinTable                   = $asinTable;
    }

    public function saveArrayToMySql(
        array $itemsArray
    ) {
        foreach ($itemsArray as $itemArray) {
            $asin = $itemArray['ASIN'];

            if ($this->bannedService->isBanned($asin)) {
                continue;
            }

            $result = $this->asinTable->updateSetIsValidWhereAsin(1, $asin);
            if ($result->getAffectedRows() == 0) {
                $this->productTable->insertAsin($asin);
            }

            $this->saveItemArrayToMySqlService->saveArrayToMySql(
                $itemArray
            );
        }
    }
}
