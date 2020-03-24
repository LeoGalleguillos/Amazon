<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\ResponseElements\Items;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class SaveArrayToMySql
{
    public function __construct(
        AmazonTable\Product\Asin $asinTable,
        AmazonService\Api\ResponseElements\Items\Item\SaveArrayToMySql $saveItemArrayToMySqlService,
        AmazonService\Product\Banned $bannedService
    ) {
        $this->asinTable                   = $asinTable;
        $this->saveItemArrayToMySqlService = $saveItemArrayToMySqlService;
        $this->bannedService               = $bannedService;
    }

    public function saveArrayToMySql(
        array $itemsArray
    ) {
        foreach ($itemsArray as $itemArray) {
            $asin = $itemArray['ASIN'];

            if ($this->bannedService->isBanned($asin)) {
                continue;
            }

            $this->asinTable->updateSetIsValidWhereAsin(1, $asin);

            $this->saveItemArrayToMySqlService->saveArrayToMySql(
                $itemArray
            );
        }
    }
}
