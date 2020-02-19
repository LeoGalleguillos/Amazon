<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Resources\ItemInfo\ExternalIds;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;

class SaveArrayToMySql
{
    public function __construct(
        AmazonService\Api\Resources\ItemInfo\ExternalIds\Eans\SaveArrayToMySql $saveEansArrayToMySqlService,
        AmazonService\Api\Resources\ItemInfo\ExternalIds\Isbns\SaveArrayToMySql $saveIsbnsArrayToMySqlService,
        AmazonService\Api\Resources\ItemInfo\ExternalIds\Upcs\SaveArrayToMySql $saveUpcsArrayToMySqlService
    ) {
        $this->saveEansArrayToMySqlService  = $saveEansArrayToMySqlService;
        $this->saveIsbnsArrayToMySqlService = $saveIsbnsArrayToMySqlService;
        $this->saveUpcsArrayToMySqlService  = $saveUpcsArrayToMySqlService;
    }

    public function saveArrayToMySql(
        array $externalIdsArray,
        int $productId
    ) {
        if (isset($externalIdsArray['EANs'])) {
            $this->saveEansArrayToMySqlService->saveArrayToMySql(
                $externalIdsArray['EANs'],
                $productId
            );
        }

        if (isset($externalIdsArray['ISBNs'])) {
            $this->saveIsbnsArrayToMySqlService->saveArrayToMySql(
                $externalIdsArray['ISBNs'],
                $productId
            );
        }

        if (isset($externalIdsArray['UPCs'])) {
            $this->saveUpcsArrayToMySqlService->saveArrayToMySql(
                $externalIdsArray['UPCs'],
                $productId
            );
        }
    }
}
