<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Operations\GetItems;

use LeoGalleguillos\Amazon\{
    Model\Service as AmazonService,
    Model\Table as AmazonTable
};

class DownloadJsonToMySql
{
    public function __construct(
        AmazonTable\Product\Asin $asinTable,
        AmazonService\Api\Errors\DownloadArrayToMySql $downloadErrorsArrayToMySqlService,
        AmazonService\Api\GetItems\Json\DownloadToMySql\ItemsResult\Items\ItemArray $itemArrayService,
        AmazonService\Product\Banned $bannedService
    ) {
        $this->asinTable                         = $asinTable;
        $this->downloadErrorsArrayToMySqlService = $downloadErrorsArrayToMySqlService;
        $this->itemArrayService                  = $itemArrayService;
        $this->bannedService                     = $bannedService;
    }

    public function downloadJsonToMySql(
        string $json
    ) {
        $jsonArray = json_decode($json, true);

        if (isset($jsonArray['Errors'])) {
            $this->downloadErrorsArrayToMySqlService->downloadArrayToMySql(
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

                $this->itemArrayService->downloadToMySql(
                    $itemArray
                );
            }
        }
    }
}
