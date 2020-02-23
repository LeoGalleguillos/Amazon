<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Resources\ItemInfo\ManufactureInfo;

use LeoGalleguillos\ArrayModule\Service as ArrayModuleService;

class Set
{
    public function __construct(
        ArrayModuleService\Path\StringOrNull $stringOrNullService
    ) {
        $this->stringOrNullService = $stringOrNullService;
    }

    public function getSet(
        array $manufactureInfoArray
    ): array {
        return [
            'part_number' => $manufactureInfoArray['ItemPartNumber']['DisplayValue'] ?? null,
            'model'       => $manufactureInfoArray['Model']['DisplayValue'] ?? null,
            'warranty'    => $this->getWarranty($manufactureInfoArray),
        ];
    }

    /**
     * @return string|null
     */
    protected function getWarranty(array $manufactureInfoArray)
    {
        return $this->stringOrNullService->getStringOrNull(
            ['Warranty', 'DisplayValue'],
            $manufactureInfoArray,
            1023
        );
    }
}
