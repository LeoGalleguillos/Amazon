<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Operations\GetItems;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;

class GetJsonAndDownloadJsonToMySql
{
    public function __construct(
        AmazonService\Api\Operations\GetItems\Json $jsonService,
        AmazonService\Api\Operations\GetItems\SaveJsonToMySql $saveJsonToMySqlService
    ) {
        $this->jsonService            = $jsonService;
        $this->saveJsonToMySqlService = $saveJsonToMySqlService;
    }

    public function getJsonAndDownloadJsonToMySql(
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
