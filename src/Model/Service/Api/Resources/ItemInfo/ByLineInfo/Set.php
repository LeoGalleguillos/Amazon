<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Resources\ItemInfo\ByLineInfo;

use MonthlyBasis\ArrayModule\Service as ArrayModuleService;

class Set
{
    public function __construct(
        ArrayModuleService\Path\StringOrNull $stringOrNullService
    ) {
        $this->stringOrNullService = $stringOrNullService;
    }

    public function getSet(
        array $byLineInfoArray
    ): array {
        return [
            'brand'        => $this->getBrand($byLineInfoArray),
            'manufacturer' => $this->getManufacturer($byLineInfoArray),
        ];
    }

    /**
     * @return string|null
     */
    protected function getBrand(array $byLineInfoArray)
    {
        return $this->stringOrNullService->getStringOrNull(
            ['Brand', 'DisplayValue'],
            $byLineInfoArray,
            255
        );
    }

    /**
     * @return string|null
     */
    protected function getManufacturer(array $byLineInfoArray)
    {
        return $this->stringOrNullService->getStringOrNull(
            ['Manufacturer', 'DisplayValue'],
            $byLineInfoArray,
            255
        );
    }
}
