<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Resources\Images;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\TableGateway as AmazonTableGateway;

class SaveArrayToMySql
{
    public function __construct(
    ) {
    }

    public function saveArrayToMySql(
        array $imagesArray,
        int $productId
    ) {
        if (isset($imagesArray['Primary'])) {
        }

        if (isset($imagesArray['Variants'])) {
        }
    }
}
