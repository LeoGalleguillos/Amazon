<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\GetItems\Json;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;

class DownloadToMySql
{
    public function __construct(
        AmazonService\Api\GetItems\Json\DownloadToMySql\ItemsResult\Items\ItemArray $itemArrayService
    ) {
        $this->itemArrayService = $itemArrayService;
    }

    public function downloadToMySql(
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
