<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Operations\GetItems;

use LeoGalleguillos\Amazon\{
    Model\Service as AmazonService,
    Model\Table as AmazonTable
};

class DownloadJsonToMySql
{
    public function __construct(
        AmazonService\Api\GetItems\Json\DownloadToMySql\ItemsResult\Items\ItemArray $itemArrayService,
        AmazonTable\Product\Asin $asinTable
    ) {
        $this->itemArrayService = $itemArrayService;
        $this->asinTable        = $asinTable;
    }

    public function downloadJsonToMySql(
        string $json
    ): bool {
        $jsonArray = json_decode($json, true);

        if (isset($jsonArray['Errors'])) {
            foreach ($jsonArray['Errors'] as $errorArray) {
                $pattern = '/The ItemId (\w+) provided in the request is invalid./';
                if (preg_match($pattern, $errorArray['Message'], $matches)) {
                    $asin = $matches[1];
                    $this->asinTable->updateSetInvalidWhereAsin(
                        0,
                        $asin
                    );
                }
            }
        }

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
