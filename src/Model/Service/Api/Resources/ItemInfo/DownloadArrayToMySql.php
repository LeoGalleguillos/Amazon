<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Resources\ItemInfo;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\TableGateway as AmazonTableGateway;

class DownloadArrayToMySql
{
    public function __construct(
        AmazonTableGateway\Product $productTableGateway
    ) {
        $this->productTableGateway = $productTableGateway;
    }

    public function downloadArrayToMySql(
        array $itemInfoArray,
        int $productId
    ) {
        $affectedRows = $this->productTableGateway->update(
            [
                'color' => $itemInfoArray['ProductInfo']['Color']['DisplayValue'] ?? null,
            ],
            ['product_id' => $productId]
        );
    }
}
