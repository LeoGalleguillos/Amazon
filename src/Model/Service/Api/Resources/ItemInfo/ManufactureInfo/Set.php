<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Resources\ItemInfo\ManufactureInfo;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;

class Set
{
    public function __construct(
        AmazonService\Api\Resources\ItemInfo\ManufactureInfo\Warranty\DisplayValue\StringOrNull $warrantyStringOrNullService
    ) {
        $this->warrantyStringOrNullService = $warrantyStringOrNullService;
    }

    public function getSet(
        array $manufactureInfoArray
    ): array {
        return [
            'part_number' => $manufactureInfoArray['ItemPartNumber']['DisplayValue'] ?? null,
            'model'       => $manufactureInfoArray['Model']['DisplayValue'] ?? null,
            'warranty'    => $this->warrantyStringOrNullService->getStringOrNull($manufactureInfoArray),
        ];
    }
}
