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
            'part_number' => $this->getPartNumber($manufactureInfoArray),
            'model'       => $manufactureInfoArray['Model']['DisplayValue'] ?? null,
            'warranty'    => $this->getWarranty($manufactureInfoArray),
        ];
    }

    /**
     * @return string|null
     */
    protected function getPartNumber(array $manufactureInfoArray)
    {
        return $this->stringOrNullService->getStringOrNull(
            ['ItemPartNumber', 'DisplayValue'],
            $manufactureInfoArray,
            127
        );
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
