<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Operations\GetItems;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class SaveJsonToMySql
{
    public function __construct(
        AmazonService\Api\Errors\SaveArrayToMySql $saveErrorsArrayToMySqlService,
        AmazonService\Api\ResponseElements\Items\SaveArrayToMySql $saveItemsArrayToMySqlService
    ) {
        $this->saveErrorsArrayToMySqlService = $saveErrorsArrayToMySqlService;
        $this->saveItemsArrayToMySqlService  = $saveItemsArrayToMySqlService;
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
            $this->saveItemsArrayToMySqlService->saveArrayToMySql(
                $jsonArray['ItemsResult']['Items']
            );
        }
    }
}
