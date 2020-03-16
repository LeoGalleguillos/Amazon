<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Resources\ItemInfo\Classifications;

use LeoGalleguillos\ArrayModule\Service as ArrayModuleService;

class Set
{
    public function __construct(
        ArrayModuleService\Path\StringOrNull $stringOrNullService
    ) {
        $this->stringOrNullService = $stringOrNullService;
    }

    public function getSet(
        array $classificationsArray
    ): array {
        return [
            'binding'       => $this->getBinding($classificationsArray),
            'product_group' => $this->getProductGroup($classificationsArray),
        ];
    }

    /**
     * @return string|null
     */
    protected function getBinding(array $classificationsArray)
    {
        return $this->stringOrNullService->getStringOrNull(
            ['Binding', 'DisplayValue'],
            $classificationsArray,
            255
        );
    }

    /**
     * @return string|null
     */
    protected function getProductGroup(array $classificationsArray)
    {
        return $this->stringOrNullService->getStringOrNull(
            ['ProductGroup', 'DisplayValue'],
            $classificationsArray,
            255
        );
    }
}
