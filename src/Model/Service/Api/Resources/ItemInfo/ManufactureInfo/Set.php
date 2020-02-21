<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Resources\ItemInfo\ManufactureInfo;

class Set
{
    public function getSet(
        array $manufactureInfoArray
    ): array {
        return [
            'part_number' => $manufactureInfoArray['ItemPartNumber']['DisplayValue'] ?? null,
            'model'       => $manufactureInfoArray['Model']['DisplayValue'] ?? null,
            'warranty'    => $manufactureInfoArray['Warranty']['DisplayValue'] ?? null,
        ];
    }
}
