<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Operations\GetItems;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;

class DownloadJsonToMySql
{
    public function __construct(
        AmazonService\Api\GetItems\Json\DownloadToMySql\ItemsResult\Items\ItemArray $itemArrayService
    ) {
        $this->itemArrayService = $itemArrayService;
    }

    public function downloadJsonToMySql(
        string $json
    ): bool {
        $jsonArray = json_decode($json, true);

        if (isset($jsonArray['ItemsResult']['Items'])) {
            $itemsArray = $jsonArray['ItemsResult']['Items'];
            foreach ($itemsArray as $itemArray) {
                $this->itemArrayService->downloadToMySql(
                    $itemArray
                );
            }
        }

        return true;
    }
}
