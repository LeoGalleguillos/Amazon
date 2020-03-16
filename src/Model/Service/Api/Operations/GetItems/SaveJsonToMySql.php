<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Operations\GetItems;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class SaveJsonToMySql
{
    public function __construct(
        AmazonTable\Product\Asin $asinTable,
        AmazonService\Api\Errors\SaveArrayToMySql $saveErrorsArrayToMySqlService,
        AmazonService\Api\ResponseElements\Items\Item\SaveArrayToMySql $saveItemArrayToMySqlService,
        AmazonService\Product\Banned $bannedService
    ) {
        $this->asinTable                     = $asinTable;
        $this->saveErrorsArrayToMySqlService = $saveErrorsArrayToMySqlService;
        $this->saveItemArrayToMySqlService   = $saveItemArrayToMySqlService;
        $this->bannedService                 = $bannedService;
    }

    public function saveJsonToMySql(
        string $json
    ) {
        $jsonArray = json_decode($json, true);

        if (isset($jsonArray['Errors'])) {
            $this->saveErrorsArrayToMySqlService->saveArrayToMySql(
                $jsonArray['Errors']
            );
        }

        if (isset($jsonArray['ItemsResult']['Items'])) {
            $itemsArray = $jsonArray['ItemsResult']['Items'];
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
}
