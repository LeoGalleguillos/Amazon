<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Resources\ItemInfo;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\TableGateway as AmazonTableGateway;
use LeoGalleguillos\ArrayModule\Service as ArrayModuleService;

class SaveArrayToMySql
{
    public function __construct(
        AmazonService\Api\Resources\ItemInfo\ByLineInfo\Set $byLineInfoSetService,
        AmazonService\Api\Resources\ItemInfo\Classifications\Set $classificationsSetService,
        AmazonService\Api\Resources\ItemInfo\ExternalIds\SaveArrayToMySql $saveExternalIdsArrayToMySqlService,
        AmazonService\Api\Resources\ItemInfo\Features\SaveArrayToMySql $saveFeaturesArrayToMySqlService,
        AmazonService\Api\Resources\ItemInfo\ManufactureInfo\Set $manufactureInfoSetService,
        AmazonService\Api\Resources\ItemInfo\Title\Set $titleSetService,
        AmazonService\Api\Resources\ItemInfo\TradeInInfo\Set $tradeInInfoSetService,
        AmazonTableGateway\Product $productTableGateway,
        ArrayModuleService\Path\StringOrNull $stringOrNullService
    ) {
        $this->byLineInfoSetService               = $byLineInfoSetService;
        $this->classificationsSetService          = $classificationsSetService;
        $this->saveExternalIdsArrayToMySqlService = $saveExternalIdsArrayToMySqlService;
        $this->saveFeaturesArrayToMySqlService    = $saveFeaturesArrayToMySqlService;
        $this->manufactureInfoSetService          = $manufactureInfoSetService;
        $this->titleSetService                    = $titleSetService;
        $this->tradeInInfoSetService              = $tradeInInfoSetService;
        $this->productTableGateway                = $productTableGateway;
        $this->stringOrNullService                = $stringOrNullService;
    }

    public function saveArrayToMySql(
        array $itemInfoArray,
        int $productId
    ) {
        $set = [
            'color' => $this->getColor($itemInfoArray),
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
            'size' => $this->getSize($itemInfoArray),
            'unit_count' => $itemInfoArray['ProductInfo']['UnitCount']['DisplayValue'] ?? null,
        ];

        if (isset($itemInfoArray['ByLineInfo'])) {
            $set += $this->byLineInfoSetService->getSet(
                $itemInfoArray['ByLineInfo']
            );
        }

        if (isset($itemInfoArray['Classifications'])) {
            $set += $this->classificationsSetService->getSet(
                $itemInfoArray['Classifications']
            );
        }

        if (isset($itemInfoArray['ManufactureInfo'])) {
            $set += $this->manufactureInfoSetService->getSet(
                $itemInfoArray['ManufactureInfo']
            );
        }

        if (isset($itemInfoArray['Title'])) {
            $set += $this->titleSetService->getSet(
                $itemInfoArray['Title']
            );
        }

        if (isset($itemInfoArray['TradeInInfo'])) {
            $set += $this->tradeInInfoSetService->getSet(
                $itemInfoArray['TradeInInfo']
            );
        }

        $this->productTableGateway->update(
            $set,
            ['product_id' => $productId]
        );

        if (isset($itemInfoArray['ExternalIds'])) {
            $this->saveExternalIdsArrayToMySqlService->saveArrayToMySql(
                $itemInfoArray['ExternalIds'],
                $productId
            );
        }

        if (isset($itemInfoArray['Features'])) {
            $this->saveFeaturesArrayToMySqlService->saveArrayToMySql(
                $itemInfoArray['Features'],
                $productId
            );
        }
    }

    /**
     * @return string|null
     */
    protected function getColor(array $itemInfoArray)
    {
        return $this->stringOrNullService->getStringOrNull(
            ['ProductInfo', 'Color', 'DisplayValue'],
            $itemInfoArray,
            255
        );
    }

    /**
     * @return string|null
     */
    protected function getSize(array $itemInfoArray)
    {
        return $this->stringOrNullService->getStringOrNull(
            ['ProductInfo', 'Size', 'DisplayValue'],
            $itemInfoArray,
            127
        );
    }
}
