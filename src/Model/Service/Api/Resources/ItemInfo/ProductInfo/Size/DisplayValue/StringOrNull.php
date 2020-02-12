<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Resources\ItemInfo\ProductInfo\Size\DisplayValue;

class StringOrNull
{
    public function getStringOrNull(
        array $itemInfoArray
    ) {
        if (isset($itemInfoArray['ProductInfo']['Size']['DisplayValue'])) {
            $displayValue = $itemInfoArray['ProductInfo']['Size']['DisplayValue'];
        } else {
            return null;
        }

        if (strlen($displayValue) > 127) {
            return null;
        }

        return $displayValue;
    }
}
