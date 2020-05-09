<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Resources\Offers;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;

class SaveArrayToMySql
{
    public function __construct(
        AmazonService\Api\Resources\Offers\Listings\SaveArrayToMySql $saveListingsArrayToMySqlService,
        AmazonService\Api\Resources\Offers\Summaries\SaveArrayToMySql $saveSummariesArrayToMySqlService
    ) {
        $this->saveListingsArrayToMySqlService  = $saveListingsArrayToMySqlService;
        $this->saveSummariesArrayToMySqlService = $saveSummariesArrayToMySqlService;
    }

    public function saveArrayToMySql(
        array $offersArray,
        int $productId
    ) {
        if (isset($offersArray['Listings'])) {
            $this->saveListingsArrayToMySqlService->saveArrayToMySql(
                $offersArray['Listings'],
                $productId
            );
        }
        if (isset($offersArray['Summaries'])) {
            $this->saveSummariesArrayToMySqlService->saveArrayToMySql(
                $offersArray['Summaries'],
                $productId
            );
        }
    }
}
