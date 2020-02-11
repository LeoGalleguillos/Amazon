<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Resources\ItemInfo\ProductInfo\Color\DisplayValue;

class StringOrNull
{
    public function getStringOrNull(
        array $itemInfoArray
    ) {
        if (isset($itemInfoArray['ProductInfo']['Color']['DisplayValue'])) {
            $displayValue = $itemInfoArray['ProductInfo']['Color']['DisplayValue'];
        } else {
            return null;
        }

        if (strlen($displayValue) > 255) {
            return null;
        }

        return $displayValue;
    }
}
