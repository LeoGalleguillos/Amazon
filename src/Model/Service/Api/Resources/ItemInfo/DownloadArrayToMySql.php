<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Resources\ItemInfo;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\TableGateway as AmazonTableGateway;

class DownloadArrayToMySql
{
    public function __construct(
        AmazonService\Api\Resources\ItemInfo\ProductInfo\Color\DisplayValue\StringOrNull $stringOrNullService,
        AmazonTableGateway\Product $productTableGateway
    ) {
        $this->stringOrNullService = $stringOrNullService;
        $this->productTableGateway = $productTableGateway;
    }

    public function downloadArrayToMySql(
        array $itemInfoArray,
        int $productId
    ) {
        $affectedRows = $this->productTableGateway->update(
            [
                'color' => $this->stringOrNullService->getStringOrNull($itemInfoArray),
                'is_adult_product' => isset($itemInfoArray['ProductInfo']['IsAdultProduct']['DisplayValue'])
                    ? ((int) $itemInfoArray['ProductInfo']['IsAdultProduct']['DisplayValue'])
                    : null,
                'height_value' => isset($itemInfoArray['ProductInfo']['ItemDimensions']['Height']['DisplayValue'])
                    ? ((float) $itemInfoArray['ProductInfo']['ItemDimensions']['Height']['DisplayValue'])
                    : null,
                    'height_units' => $itemInfoArray['ProductInfo']['ItemDimensions']['Height']['Unit']
                    ?? null,
                'length_value' => isset($itemInfoArray['ProductInfo']['ItemDimensions']['Length']['DisplayValue'])
                    ? ((float) $itemInfoArray['ProductInfo']['ItemDimensions']['Length']['DisplayValue'])
                    : null,
                    'length_units' => $itemInfoArray['ProductInfo']['ItemDimensions']['Length']['Unit']
                    ?? null,
                'weight_value' => isset($itemInfoArray['ProductInfo']['ItemDimensions']['Weight']['DisplayValue'])
                    ? ((float) $itemInfoArray['ProductInfo']['ItemDimensions']['Weight']['DisplayValue'])
                    : null,
                    'weight_units' => $itemInfoArray['ProductInfo']['ItemDimensions']['Weight']['Unit']
                    ?? null,
                'width_value' => isset($itemInfoArray['ProductInfo']['ItemDimensions']['Width']['DisplayValue'])
                    ? ((float) $itemInfoArray['ProductInfo']['ItemDimensions']['Width']['DisplayValue'])
                    : null,
                    'width_units' => $itemInfoArray['ProductInfo']['ItemDimensions']['Width']['Unit']
                    ?? null,
                'released' => isset($itemInfoArray['ProductInfo']['ReleaseDate']['DisplayValue'])
                    ? date(
                        'Y-m-d H:i:s',
                        strtotime($itemInfoArray['ProductInfo']['ReleaseDate']['DisplayValue'])
                      )
                    : null,
            ],
            ['product_id' => $productId]
        );
    }
}
