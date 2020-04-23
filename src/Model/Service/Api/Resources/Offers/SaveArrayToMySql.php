<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Resources\Offers;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;

class SaveArrayToMySql
{
    public function __construct(
        AmazonService\Api\Resources\Offers\Summaries\SaveArrayToMySql $saveSummariesArrayToMySqlService
    ) {
        $this->saveSummariesArrayToMySqlService = $saveSummariesArrayToMySqlService;
    }

    public function saveArrayToMySql(
        array $offersArray,
        int $productId
    ) {
        if (isset($offersArray['Summaries'])) {
            $this->saveSummariesArrayToMySqlService->saveArrayToMySql(
                $offersArray['Summaries'],
                $productId
            );
        }
    }
}
