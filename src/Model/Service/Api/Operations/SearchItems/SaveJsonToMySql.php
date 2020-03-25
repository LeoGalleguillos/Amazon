<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Operations\SearchItems;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;

class SaveJsonToMySql
{
    public function __construct(
        AmazonService\Api\ResponseElements\Items\SaveArrayToMySql $saveItemsArrayToMySqlService
    ) {
        $this->saveItemsArrayToMySqlService = $saveItemsArrayToMySqlService;
    }

    public function saveJsonToMySql(
        string $json
    ) {
        $jsonArray = json_decode($json, true);

        if (isset($jsonArray['SearchResult']['Items'])) {
            $this->saveItemsArrayToMySqlService->saveArrayToMySql(
                $jsonArray['SearchResult']['Items']
            );
        }
    }
}
