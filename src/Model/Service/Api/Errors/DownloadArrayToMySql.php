<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Errors;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class DownloadArrayToMySql
{
    public function __construct(
        AmazonTable\Product\Asin $asinTable
    ) {
        $this->asinTable = $asinTable;
    }

    public function downloadArrayToMySql(
        array $errorsArray
    ) {
        foreach ($errorsArray as $errorArray) {
            $pattern = '/The ItemId (\w+) provided in the request is invalid./';
            if (($errorArray['Code'] == 'InvalidParameterValue')
                && (preg_match($pattern, $errorArray['Message'], $matches))
            ) {
                $asin = $matches[1];
                $this->asinTable->updateSetIsValidWhereAsin(
                    0,
                    $asin
                );
            }
        }
    }
}
