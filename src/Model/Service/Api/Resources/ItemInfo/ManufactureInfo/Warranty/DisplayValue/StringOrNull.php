<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Resources\ItemInfo\ManufactureInfo\Warranty\DisplayValue;

class StringOrNull
{
    public function getStringOrNull(
        array $manufactureInfoArray
    ) {
        if (!isset($manufactureInfoArray['Warranty']['DisplayValue'])) {
            return null;
        }

        $warranty = $manufactureInfoArray['Warranty']['DisplayValue'];

        if (strlen($warranty) >= 1024) {
            return null;
        }

        return $warranty;
    }
}
