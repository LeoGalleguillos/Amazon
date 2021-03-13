<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Errors;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class SaveArrayToMySql
{
    public function __construct(
        AmazonTable\Product\Asin $asinTable
    ) {
        $this->asinTable = $asinTable;
    }

    public function saveArrayToMySql(
        array $errorsArray
    ) {
        $patterns = [
            '/The ItemId (\w+) provided in the request is invalid./',
            '/The ItemId (\w+) is not accessible through the Product Advertising API./',
        ];

        foreach ($errorsArray as $errorArray) {
            foreach ($patterns as $pattern) {
                if (preg_match($pattern, $errorArray['Message'], $matches)) {
                    $asin = $matches[1];
                    $this->asinTable->updateSetModifiedToUtcTimestampWhereAsin($asin);
                    $this->asinTable->updateSetIsValidWhereAsin(0, $asin);
                    continue;
                }
            }
        }
    }
}
