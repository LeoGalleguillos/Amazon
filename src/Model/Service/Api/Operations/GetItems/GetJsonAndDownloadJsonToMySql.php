<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Operations\GetItems;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;

class GetJsonAndDownloadJsonToMySql
{
    public function __construct(
        AmazonService\Api\Operations\GetItems\DownloadJsonToMySql $downloadJsonToMySqlService,
        AmazonService\Api\Operations\GetItems\Json $jsonService
    ) {
        $this->downloadJsonToMySqlService = $downloadJsonToMySqlService;
        $this->jsonService                = $jsonService;
    }

    public function getJsonAndDownloadJsonToMySql(
        array $itemIds,
        array $resources
    ) {
        $json = $this->jsonService->getJson(
            $itemIds,
            $resources
        );
        $this->downloadJsonToMySqlService->downloadJsonToMySql(
            $json
        );
    }
}
