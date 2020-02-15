<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Resources\ItemInfo\ExternalIds;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;

class SaveArrayToMySql
{
    public function __construct(
        AmazonService\Api\Resources\ItemInfo\ExternalIds\Eans\SaveArrayToMySql $saveEansArrayToMySqlService
    ) {
        $this->saveEansArrayToMySqlService = $saveEansArrayToMySqlService;
    }

    public function saveArrayToMySql(
        array $externalIdsArray,
        int $productId
    ) {

    }
}
