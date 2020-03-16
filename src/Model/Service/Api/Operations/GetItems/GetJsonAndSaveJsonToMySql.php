<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Operations\GetItems;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;

class GetJsonAndSaveJsonToMySql
{
    public function __construct(
        AmazonService\Api\Operations\GetItems\Json $jsonService,
        AmazonService\Api\Operations\GetItems\SaveJsonToMySql $saveJsonToMySqlService
    ) {
        $this->jsonService            = $jsonService;
        $this->saveJsonToMySqlService = $saveJsonToMySqlService;
    }

    public function getJsonAndSaveJsonToMySql(
        array $itemIds,
        array $resources
    ) {
        $json = $this->jsonService->getJson(
            $itemIds,
            $resources
        );
        $this->saveJsonToMySqlService->saveJsonToMySql(
            $json
        );
    }
}
