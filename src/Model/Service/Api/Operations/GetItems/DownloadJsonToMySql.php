<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Operations\GetItems;

use LeoGalleguillos\Amazon\{
    Model\Service as AmazonService,
    Model\Table as AmazonTable
};

class DownloadJsonToMySql
{
    public function __construct(
        AmazonService\Api\Errors\DownloadArrayToMySql $downloadErrorsArrayToMySqlService,
        AmazonService\Api\GetItems\Json\DownloadToMySql\ItemsResult\Items\ItemArray $itemArrayService
    ) {
        $this->downloadErrorsArrayToMySqlService = $downloadErrorsArrayToMySqlService;
        $this->itemArrayService                  = $itemArrayService;
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
                $this->itemArrayService->downloadToMySql(
                    $itemArray
                );
            }
        }
    }
}
