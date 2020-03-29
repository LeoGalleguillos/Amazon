<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Resources\ItemInfo\Title;

use LeoGalleguillos\ArrayModule\Service as ArrayModuleService;

class Set
{
    public function __construct(
        ArrayModuleService\Path\StringOrNull $stringOrNullService
    ) {
        $this->stringOrNullService = $stringOrNullService;
    }

    public function getSet(
        array $titleArray
    ): array {
        return [
            'title' => $this->stringOrNullService->getStringOrNull(
                ['DisplayValue'],
                $titleArray,
                255
            ),
        ];
    }
}
